<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIRA Clone - {{ auth()->user()->name ?? 'User' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}", type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">J</div>
            <div>
                <div style="font-weight: 600; color: #333;">JIRA Clone</div>
                <div style="font-size: 12px; color: #666;">Project Management</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-section="dashboard">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('projects.index') }}" class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}" data-section="projects">
                <i class="fas fa-project-diagram"></i> Loyihalar
            </a>
            <a href="{{ route('issues.index') }}" class="nav-item {{ request()->routeIs('issues.*') ? 'active' : '' }}" data-section="tasks">
                <i class="fas fa-tasks"></i> Vazifalar
            </a>
            <a href="{{ route('team.index') }}" class="nav-item {{ request()->routeIs('team.*') ? 'active' : '' }}" data-section="team">
                <i class="fas fa-users"></i> Jamoa
            </a>
            @if(auth()->user()->is_admin)
                <a href="{{ route('penalties.index') }}" class="nav-item {{ request()->routeIs('penalties.*') ? 'active' : '' }}" data-section="penalties">
                    <i class="fas fa-exclamation-triangle"></i> Jarimalar
                </a>
            @endif
            <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" data-section="reports">
                <i class="fas fa-chart-bar"></i> Hisobotlar
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <h1 id="page-title">Dashboard</h1>
            </div>
            <div class="topbar-right">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ auth()->user()->name }}</span>
                    @if(auth()->user()->is_admin)
                        <span class="badge" style="background: #ff6b6b; color: white;">ADMIN</span>
                    @else
                        <span class="badge" style="background: #51cf66; color: white;">USER</span>
                    @endif
                </div>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('register') }}" class="btn-primary">
                        <i class="fas fa-user-plus"></i> Add User
                    </a>
                    <button class="btn-primary" onclick="showPenaltyModal()">
                        <i class="fas fa-exclamation-triangle"></i> Penalty
                    </button>
                @endif
                <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Chiqish
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </header>

        <div class="dashboard-container" id="content-area">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <h2>Xush kelibsiz, {{ auth()->user()->name }}!</h2>
                <p>Loyihalaringizni boshqaring va vazifalarni kuzating</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>{{ $statistics['total_issues'] ?? 0 }}</h3>
                    <p>Jami vazifalar</p>
                    <div class="icon"><i class="fas fa-tasks"></i></div>
                </div>
                <div class="stat-card">
                    <h3>{{ $statistics['in_progress_count'] ?? 0 }}</h3>
                    <p>Jarayondagi vazifalar</p>
                    <div class="icon"><i class="fas fa-clock"></i></div>
                </div>
                <div class="stat-card">
                    <h3>{{ $statistics['done_count'] ?? 0 }}</h3>
                    <p>Tugallangan vazifalar</p>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                </div>
                <div class="stat-card">
                    <h3>{{ $statistics['my_issues'] ?? 0 }}</h3>
                    <p>Mening vazifalarim</p>
                    <div class="icon"><i class="fas fa-user-check"></i></div>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">Barcha loyihalar</h3>
                    @if(auth()->user()->is_admin)
                        <button class="btn-primary" onclick="openProjectModal()">
                            <i class="fas fa-plus"></i> Yangi loyiha
                        </button>
                    @endif
                </div>
                <div class="projects-grid">
                    @if(empty($allProjects) || $allProjects->isEmpty())
                        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                            <i class="fas fa-project-diagram" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
                            <p>Hozircha loyihalar yo'q. @if(auth()->user()->is_admin) Birinchi loyihangizni yarating! @else Admin loyiha yaratganda ko'rinadi. @endif</p>
                        </div>
                    @else
                        @foreach($allProjects->take(6) as $project)
                            <div class="project-card">
                                <div class="project-header">
                                    <div>
                                        <div class="project-name">{{ $project->name ?? 'N/A' }}</div>
                                        <div class="project-description">{{ \Illuminate\Support\Str::limit($project->description ?? '', 100, '...') }}</div>
                                    </div>
                                    <div class="project-status status-{{ $project->status ?? 'active' }}">
                                        {{ $project->status === 'active' ? 'Faol' : 'Tugallangan' }}
                                    </div>
                                </div>
                                <div class="project-footer">
                                    <small>
                                        Yaratuvchi: {{ $project->owner->name ?? 'N/A' }}<br>
                                        {{ $project->created_at ? $project->created_at->format('d.m.Y') : 'N/A' }}
                                    </small>
                                    <div class="project-actions">
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn-sm btn-view">Ko'rish</a>
                                        @if(auth()->user()->is_admin || $project->owner_id == auth()->user()->id)
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn-sm btn-edit">Tahrirlash</a>
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="delete-project-form" data-project-id="{{ $project->id }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm btn-delete">O'chirish</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Recent Issues -->
            <div class="content-section">
                <div class="section-header">
                    <h3 class="section-title">So'nggi vazifalar</h3>
                    <button class="btn-primary" onclick="openIssueModal()">
                        <i class="fas fa-plus"></i> Yangi vazifa
                    </button>
                </div>
                @if(empty($recentIssues) || $recentIssues->isEmpty())
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-tasks" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
                        <p>Hozircha vazifalar yo'q.</p>
                    </div>
                @else
                    <ul class="task-list">
                        @foreach($recentIssues as $issue)
                            <li class="task-item">
                                <div class="task-content">
                                    <div class="task-title">{{ $issue->title ?? 'N/A' }}</div>
                                    <div class="task-meta">
                                        Loyiha: {{ $issue->project->name ?? 'N/A' }} •
                                        Mas'ul: {{ $issue->assignee->name ?? 'Tayinlanmagan' }} •
                                        Yaratuvchi: {{ $issue->reporter->name ?? 'N/A' }} •
                                        {{ \Carbon\Carbon::parse($issue->created_at)->format('d.m.Y') }}
                                        @if($issue->due_date)
                                            • Tugash: {{ \Carbon\Carbon::parse($issue->due_date)->format('d.m.Y') }}
                                            @if(\Carbon\Carbon::parse($issue->due_date)->isPast() && $issue->status !== 'done')
                                                <span class="text-red-500"> (Kechikkan)</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="task-priority priority-{{ $issue->priority ?? 'medium' }}">
                                        {{ ['high' => 'Yuqori', 'medium' => 'O\'rta', 'low' => 'Past', 'urgent' => 'Shoshilinch'][$issue->priority] ?? 'O\'rta' }}
                                    </div>
                                    @if($issue->status !== 'done')
                                        <button class="btn-sm btn-view" onclick="completeIssue({{ $issue->id }})">
                                            <i class="fas fa-check"></i> Tugallandi
                                        </button>
                                        @if(auth()->user()->is_admin && $issue->due_date && \Carbon\Carbon::parse($issue->due_date)->isPast())
                                            <button class="btn-sm btn-delete" onclick="showPenaltyModal({{ $issue->assignee_id ?? 'null' }}, {{ $issue->id }})">
                                                <i class="fas fa-exclamation-circle"></i> Jarima qo'shish
                                            </button>
                                        @endif
                                    @else
                                        <span style="color: #27ae60; font-weight: bold;">
                                            <i class="fas fa-check-circle"></i> Tugallangan
                                        </span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Project Modal -->
            <div id="projectModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Yangi loyiha yaratish</h3>
                        <span class="close" onclick="closeProjectModal()">&times;</span>
                    </div>
                    <form id="projectForm" action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="projectName">Loyiha nomi</label>
                            <input type="text" id="projectName" name="name" required>
                            <span id="projectNameError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="projectDescription">Tavsif</label>
                            <textarea id="projectDescription" name="description" rows="4"></textarea>
                            <span id="projectDescriptionError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="projectStatus">Holat</label>
                            <select id="projectStatus" name="status">
                                <option value="active">Faol</option>
                                <option value="completed">Tugallangan</option>
                            </select>
                            <span id="projectStatusError" class="error-message"></span>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%;">Loyiha yaratish</button>
                    </form>
                </div>
            </div>

            <!-- Issue Modal -->
            <div id="issueModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Yangi vazifa yaratish</h3>
                        <span class="close" onclick="closeIssueModal()">&times;</span>
                    </div>
                    <form id="issueForm" action="{{ route('issues.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="issueTitle">Vazifa nomi</label>
                            <input type="text" id="issueTitle" name="title" required>
                            <span id="issueTitleError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="issueDescription">Tavsif</label>
                            <textarea id="issueDescription" name="description" rows="4"></textarea>
                            <span id="issueDescriptionError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="issueProject">Loyiha</label>
                            <select id="issueProject" name="project_id" required>
                                <option value="">Loyihani tanlang</option>
                                @foreach($allProjects ?? [] as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            <span id="issueProjectError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="issueAssignee">Mas'ul shaxs</label>
                            <select id="issueAssignee" name="assignee_id">
                                <option value="">Mas'ul shaxsni tanlang</option>
                                @foreach($users ?? [] as $u)
                                    @if($u->is_active)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span id="issueAssigneeError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="issuePriority">Muhimlik darajasi</label>
                            <select id="issuePriority" name="priority">
                                <option value="low">Past</option>
                                <option value="medium" selected>O'rta</option>
                                <option value="high">Yuqori</option>
                                <option value="urgent">Shoshilinch</option>
                            </select>
                            <span id="issuePriorityError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="issueDueDate">Tugash sanasi</label>
                            <input type="date" id="issueDueDate" name="due_date">
                            <span id="issueDueDateError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="issueEstimatedTime">Taxminiy vaqt (soat)</label>
                            <input type="number" id="issueEstimatedTime" name="estimated_time" min="0" value="0" required>
                            <span id="issueEstimatedTimeError" class="error-message"></span>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%;">Vazifa yaratish</button>
                    </form>
                </div>
            </div>

            <!-- Penalty Modal -->
            <div id="penaltyModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Jarima solish</h3>
                        <span class="close" onclick="closePenaltyModal()">&times;</span>
                    </div>
                    <form id="penaltyForm" action="{{ route('penalties.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="penaltyUserId" name="user_id">
                        <input type="hidden" id="penaltyIssueId" name="issue_id">
                        <div class="form-group">
                            <label for="penaltyAmount">Jarima miqdori (so'm)</label>
                            <input type="number" id="penaltyAmount" name="amount" step="1000" min="0" required>
                            <span id="penaltyAmountError" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="penaltyReason">Jarima sababi</label>
                            <textarea id="penaltyReason" name="reason" rows="3" required placeholder="Vazifani vaqtida bajarmagan..."></textarea>
                            <span id="penaltyReasonError" class="error-message"></span>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; background: #ff4757;">Jarima solish</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

  <!-- footerga joylash tavsiya etiladi (sahifa yuklanganidan keyin ishlashi uchun) -->
<script src="/js/dashboard.js" defer></script>

</body>
</html>
