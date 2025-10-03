<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $project->name }} - Loyiha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px 40px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 20px;
        }

        .project-title-section {
            flex: 1;
        }

        .project-name {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-active {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .status-completed {
            background: linear-gradient(135deg, #434343 0%, #000000 100%);
            color: white;
        }

        .btn-create {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(245, 87, 108, 0.3);
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(245, 87, 108, 0.4);
        }

        .project-description {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .project-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 12px;
        }

        .meta-icon {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #667eea;
        }

        .meta-content {
            flex: 1;
        }

        .meta-label {
            font-size: 12px;
            color: #666;
            display: block;
            margin-bottom: 3px;
        }

        .meta-value {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
        }

        /* Tasks Section */
        .tasks-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #667eea;
        }

        .task-stats {
            display: flex;
            gap: 10px;
        }

        .stat-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .stat-total {
            background: #e0e7ff;
            color: #4338ca;
        }

        .stat-done {
            background: #d1fae5;
            color: #065f46;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 80px;
            color: #cbd5e1;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 22px;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .btn-empty {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-empty:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        /* Task List */
        .task-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .task-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            border-left: 4px solid;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .task-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .task-card.priority-urgent {
            border-left-color: #dc2626;
            background: linear-gradient(to right, #fef2f2 0%, white 20%);
        }

        .task-card.priority-high {
            border-left-color: #ea580c;
            background: linear-gradient(to right, #fff7ed 0%, white 20%);
        }

        .task-card.priority-medium {
            border-left-color: #f59e0b;
            background: linear-gradient(to right, #fffbeb 0%, white 20%);
        }

        .task-card.priority-low {
            border-left-color: #10b981;
            background: linear-gradient(to right, #f0fdf4 0%, white 20%);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 12px;
        }

        .task-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            flex: 1;
            line-height: 1.4;
        }

        .task-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .priority-tag {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .priority-urgent { background: #fee2e2; color: #991b1b; }
        .priority-high { background: #ffedd5; color: #9a3412; }
        .priority-medium { background: #fef3c7; color: #92400e; }
        .priority-low { background: #d1fae5; color: #065f46; }

        .btn-complete {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-complete:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .status-done {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #059669;
            font-weight: 700;
            font-size: 14px;
        }

        .task-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 14px;
            color: #6b7280;
        }

        .meta-info {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .meta-info i {
            font-size: 12px;
            opacity: 0.7;
        }

        .overdue {
            color: #dc2626;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .page-header, .tasks-section {
                padding: 20px;
                border-radius: 15px;
            }

            .header-top {
                flex-direction: column;
            }

            .project-name {
                font-size: 24px;
            }

            .project-meta {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .task-header {
                flex-direction: column;
            }

            .task-actions {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Loyiha Header -->
        <div class="page-header">
            <div class="header-top">
                <div class="project-title-section">
                    <h1 class="project-name">{{ $project->name }}</h1>
                    <span class="status-badge status-{{ $project->status }}">
                        <i class="fas fa-circle"></i>
                        {{ $project->status === 'active' ? 'Faol' : 'Tugallangan' }}
                    </span>
                </div>
                <a href="{{ route('issues.create', ['project' => $project->id]) }}" class="btn-create">
                    <i class="fas fa-plus"></i>
                    <span>Yangi vazifa</span>
                </a>
            </div>

            <p class="project-description">
                {{ $project->description ?? 'Tavsif kiritilmagan' }}
            </p>

            <div class="project-meta">
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="meta-content">
                        <span class="meta-label">Yaratuvchi</span>
                        <span class="meta-value">{{ $project->owner->name ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="meta-content">
                        <span class="meta-label">Yaratilgan</span>
                        <span class="meta-value">{{ $project->created_at->format('d.m.Y') }}</span>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="meta-content">
                        <span class="meta-label">Vazifalar</span>
                        <span class="meta-value">{{ $issues->count() }} ta</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vazifalar Section -->
        <div class="tasks-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list-check"></i>
                    Vazifalar ro'yxati
                </h2>
                @if(!$issues->isEmpty())
                    <div class="task-stats">
                        <span class="stat-badge stat-total">{{ $issues->count() }} ta</span>
                        <span class="stat-badge stat-done">{{ $issues->where('status', 'done')->count() }} tugallangan</span>
                    </div>
                @endif
            </div>

            @if($issues->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3>Vazifalar yo'q</h3>
                    <p>Bu loyihada hali birorta vazifa yo'q. Yangi vazifa qo'shib boshlang!</p>
                    <a href="{{ route('issues.create', ['project' => $project->id]) }}" class="btn-empty">
                        <i class="fas fa-plus"></i> Vazifa yaratish
                    </a>
                </div>
            @else
                <div class="task-list">
                    @foreach($issues as $issue)
                        <div class="task-card priority-{{ $issue->priority }}">
                            <div class="task-header">
                                <div class="task-title">{{ $issue->title }}</div>
                                <div class="task-actions">
                                    <span class="priority-tag priority-{{ $issue->priority }}">
                                        {{ ['high' => 'Yuqori', 'medium' => 'O\'rta', 'low' => 'Past', 'urgent' => 'Shoshilinch'][$issue->priority] ?? 'O\'rta' }}
                                    </span>
                                    @if($issue->status !== 'done')
                                        <button class="btn-complete" onclick="completeIssue({{ $issue->id }})">
                                            <i class="fas fa-check"></i>
                                            Tugallandi
                                        </button>
                                    @else
                                        <span class="status-done">
                                            <i class="fas fa-check-circle"></i>
                                            Tugallangan
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="task-meta">
                                <span class="meta-info">
                                    <i class="fas fa-user"></i>
                                    Mas'ul: <strong>{{ $issue->assignee->name ?? 'Tayinlanmagan' }}</strong>
                                </span>
                                <span class="meta-info">
                                    <i class="fas fa-user-edit"></i>
                                    Yaratuvchi: {{ $issue->reporter->name ?? 'N/A' }}
                                </span>
                                <span class="meta-info">
                                    <i class="fas fa-calendar-plus"></i>
                                    {{ $issue->created_at->format('d.m.Y') }}
                                </span>
                                @if($issue->due_date)
                                    <span class="meta-info {{ \Carbon\Carbon::parse($issue->due_date)->isPast() && $issue->status !== 'done' ? 'overdue' : '' }}">
                                        <i class="fas fa-calendar-times"></i>
                                        Tugash: {{ \Carbon\Carbon::parse($issue->due_date)->format('d.m.Y') }}
                                        @if(\Carbon\Carbon::parse($issue->due_date)->isPast() && $issue->status !== 'done')
                                            (Kechikkan)
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function completeIssue(id) {
            if (!confirm('Vazifani tugallangan deb belgilaysizmi?')) return;

            fetch(`/issues/${id}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Xatolik yuz berdi. Qaytadan urinib ko\'ring.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Xatolik yuz berdi. Qaytadan urinib ko\'ring.');
            });
        }
    </script>
</body>
</html>