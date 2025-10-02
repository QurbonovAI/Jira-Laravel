<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIRA Clone - {{ auth()->user()->name ?? 'User' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f4f5f7; color: #172b4d; }
        .sidebar { width: 250px; background: #ffffff; border-right: 1px solid #dfe1e6; height: 100vh; position: fixed; top: 0; left: 0; padding: 20px; overflow-y: auto; }
        .sidebar-header { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo { width: 40px; height: 40px; background: #0052cc; color: white; display: flex; align-items: center; justify-content: center; border-radius: 3px; font-weight: bold; font-size: 20px; }
        .sidebar-nav { display: flex; flex-direction: column; gap: 5px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: #172b4d; text-decoration: none; border-radius: 3px; font-size: 14px; transition: background 0.2s; }
        .nav-item:hover, .nav-item.active { background: #ebecf0; }
        .main-content { margin-left: 250px; padding: 20px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; background: #ffffff; padding: 15px 20px; border-bottom: 1px solid #dfe1e6; margin-bottom: 20px; }
        .topbar-left h1 { font-size: 24px; font-weight: 600; }
        .topbar-right { display: flex; align-items: center; gap: 15px; }
        .user-info { display: flex; align-items: center; gap: 10px; font-size: 14px; }
        .user-info .badge { padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 500; }
        .btn-primary { background: #0052cc; color: white; padding: 8px 16px; border-radius: 3px; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 5px; transition: background 0.2s; cursor: pointer; }
        .btn-primary:hover { background: #0747a6; }
        .logout-btn { color: #ff5630; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 5px; }
        .dashboard-container { max-width: 1200px; margin: 0 auto; }
        .welcome-banner { background: #ffffff; padding: 20px; border-radius: 3px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .welcome-banner h2 { font-size: 24px; font-weight: 600; }
        .welcome-banner p { font-size: 14px; color: #6b778c; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #ffffff; padding: 20px; border-radius: 3px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); position: relative; }
        .stat-card h3 { font-size: 32px; font-weight: 600; color: #172b4d; }
        .stat-card p { font-size: 14px; color: #6b778c; }
        .stat-card .icon { position: absolute; top: 20px; right: 20px; font-size: 24px; color: #0052cc; opacity: 0.2; }
        .content-section { background: #ffffff; padding: 20px; border-radius: 3px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .section-title { font-size: 18px; font-weight: 600; }
        .projects-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .project-card { background: #ffffff; border-radius: 3px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); padding: 15px; }
        .project-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .project-name { font-size: 16px; font-weight: 600; }
        .project-description { font-size: 14px; color: #6b778c; margin-bottom: 10px; }
        .project-status { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500; }
        .status-active { background: #e3fcef; color: #00875a; }
        .status-completed { background: #dfe1e6; color: #42526e; }
        .project-footer { display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #6b778c; }
        .project-actions { display: flex; gap: 5px; }
        .btn-sm { padding: 6px 12px; border-radius: 3px; font-size: 12px; cursor: pointer; }
        .btn-view { background: #0052cc; color: white; }
        .btn-edit { background: #ffab00; color: white; }
        .btn-delete { background: #ff5630; color: white; }
        .task-list { list-style: none; }
        .task-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #f4f5f7; }
        .task-title { font-size: 16px; font-weight: 500; }
        .task-meta { font-size: 12px; color: #6b778c; margin-top: 5px; }
        .task-priority { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500; }
        .priority-high { background: #ffebe6; color: #bf2600; }
        .priority-medium { background: #fff0b3; color: #ff991f; }
        .priority-low { background: #e3fcef; color: #00875a; }
        .priority-urgent { background: #ff5630; color: white; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: #ffffff; padding: 20px; border-radius: 3px; width: 100%; max-width: 500px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h3 { font-size: 18px; font-weight: 600; }
        .close { cursor: pointer; font-size: 24px; color: #6b778c; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; border: 1px solid #dfe1e6; border-radius: 3px; font-size: 14px; }
        .alert { padding: 15px; border-radius: 3px; margin-bottom: 20px; }
        .alert-success { background: #e3fcef; color: #00875a; border-left: 4px solid #36b37e; }
        .alert-danger { background: #ffebe6; color: #bf2600; border-left: 4px solid #ff5630; }
        .error-message { color: #bf2600; font-size: 12px; margin-top: 5px; display: block; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f4f5f7; }
        ::-webkit-scrollbar-thumb { background: #c1c7d0; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a5adba; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .stats-grid, .projects-grid { grid-template-columns: 1fr; }
        }
    </style>
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

    <script>
        // Navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.dataset.section === 'dashboard') {
                    location.href = '{{ route("dashboard") }}';
                    return;
                }
                e.preventDefault();
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                const section = this.dataset.section;
                const titles = {
                    dashboard: 'Dashboard',
                    projects: 'Loyihalar',
                    tasks: 'Vazifalar',
                    team: 'Jamoa',
                    penalties: 'Jarimalar',
                    reports: 'Hisobotlar'
                };
                document.getElementById('page-title').textContent = titles[section] || 'Dashboard';
                loadContent(section);
            });
        });

        function loadContent(section) {
            const contentArea = document.getElementById('content-area');
            const routes = {
                projects: '{{ route("projects.index") }}',
                tasks: '{{ route("issues.index") }}',
                team: '{{ route("team.index") }}',
                penalties: '{{ route("penalties.index") }}',
                reports: '{{ route("reports.index") }}'
            };

            if (!routes[section]) {
                location.reload();
                return;
            }

            fetch(routes[section], {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.text())
                .then(html => {
                    contentArea.innerHTML = html;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    contentArea.innerHTML = `<div class="alert alert-danger">Xatolik: ${error.message}</div>`;
                });
        }

        // Modal Functions
        function openProjectModal() {
            document.getElementById('projectModal').style.display = 'flex';
            document.getElementById('projectForm').reset();
            clearErrors('project');
        }

        function closeProjectModal() {
            document.getElementById('projectModal').style.display = 'none';
        }

        function openIssueModal() {
            document.getElementById('issueModal').style.display = 'flex';
            document.getElementById('issueForm').reset();
            clearErrors('issue');
        }

        function closeIssueModal() {
            document.getElementById('issueModal').style.display = 'none';
        }

        function showPenaltyModal(userId = null, issueId = null) {
            if (!userId || !issueId) {
                alert('Foydalanuvchi yoki vazifa tanlanmadi!');
                return;
            }
            document.getElementById('penaltyModal').style.display = 'flex';
            document.getElementById('penaltyForm').reset();
            clearErrors('penalty');
            document.getElementById('penaltyUserId').value = userId;
            document.getElementById('penaltyIssueId').value = issueId;
        }

        function closePenaltyModal() {
            document.getElementById('penaltyModal').style.display = 'none';
        }

        function clearErrors(formPrefix) {
            const errorFields = document.querySelectorAll(`#${formPrefix}Form .error-message`);
            errorFields.forEach(field => field.textContent = '');
        }

        function completeIssue(id) {
            if (confirm('Vazifani tugallandi deb belgilashni xohlaysizmi?')) {
                fetch('{{ route("issues.complete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: `issue_id=${id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                            alert('Vazifa tugallandi!');
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Xatolik yuz berdi: ' + error.message);
                    });
            }
        }

        // Form Submission with AJAX for Project Creation
        document.getElementById('projectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeProjectModal();
                        location.reload();
                        alert('Loyiha muvaffaqiyatli yaratildi!');
                    } else {
                        clearErrors('project');
                        if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const errorField = document.getElementById(`project${key.charAt(0).toUpperCase() + key.slice(1)}Error`);
                                if (errorField) errorField.textContent = data.errors[key][0];
                            });
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Xatolik yuz berdi: ' + error.message);
                });
        });

        // Form Submission with AJAX for Project Deletion
        document.querySelectorAll('.delete-project-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!confirm('Loyihani o\'chirishni tasdiqlaysizmi?')) {
                    return;
                }
                const formData = new FormData(this);
                const projectId = this.dataset.projectId;
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Loyiha muvaffaqiyatli o\'chirildi!');
                            location.reload();
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Xatolik yuz berdi: ' + error.message);
                    });
            });
        });

        // Form Submission with AJAX for Issue
        document.getElementById('issueForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeIssueModal();
                        location.reload();
                        alert('Vazifa muvaffaqiyatli yaratildi!');
                    } else {
                        clearErrors('issue');
                        if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const errorField = document.getElementById(`issue${key.charAt(0).toUpperCase() + key.slice(1)}Error`);
                                if (errorField) errorField.textContent = data.errors[key][0];
                            });
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Xatolik yuz berdi: ' + error.message);
                });
        });

        // Form Submission with AJAX for Penalty
        document.getElementById('penaltyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closePenaltyModal();
                        location.reload();
                        alert('Jarima muvaffaqiyatli qo\'shildi!');
                    } else {
                        clearErrors('penalty');
                        if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const errorField = document.getElementById(`penalty${key.charAt(0).toUpperCase() + key.slice(1)}Error`);
                                if (errorField) errorField.textContent = data.errors[key][0];
                            });
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Xatolik yuz berdi: ' + error.message);
                });
        });

        // Close modals on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                closeProjectModal();
                closeIssueModal();
                closePenaltyModal();
            }
        };
    </script>
</body>
</html>