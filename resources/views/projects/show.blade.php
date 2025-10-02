<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">{{ $project->name }}</h3>
    </div>
    <p>{{ $project->description ?? 'Tavsif yo\'q' }}</p>
    <p><strong>Holat:</strong> {{ $project->status === 'active' ? 'Faol' : 'Tugallangan' }}</p>
    <p><strong>Yaratuvchi:</strong> {{ $project->owner->name ?? 'N/A' }}</p>
    <p><strong>Yaratilgan:</strong> {{ $project->created_at->format('d.m.Y') }}</p>
    <div class="section-header">
        <h3 class="section-title">Vazifalar</h3>
        <a href="{{ route('issues.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Yangi vazifa
        </a>
    </div>
    @if($issues->isEmpty())
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="fas fa-tasks" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
            <p>Bu loyihada vazifalar yo'q.</p>
        </div>
    @else
        <ul class="task-list">
            @foreach($issues as $issue)
                <li class="task-item">
                    <div class="task-content">
                        <div class="task-title">{{ $issue->title }}</div>
                        <div class="task-meta">
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
                        <div class="task-priority priority-{{ $issue->priority }}">
                            {{ ['high' => 'Yuqori', 'medium' => 'O\'rta', 'low' => 'Past', 'urgent' => 'Shoshilinch'][$issue->priority] ?? 'O\'rta' }}
                        </div>
                        @if($issue->status !== 'done')
                            <button class="btn-sm btn-view" onclick="completeIssue({{ $issue->id }})">
                                <i class="fas fa-check"></i> Tugallandi
                            </button>
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