<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Jamoa</h3>
    </div>
    @if($users->isEmpty())
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="fas fa-users" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
            <p>Hozircha faol foydalanuvchilar yo'q.</p>
        </div>
    @else
        <div class="projects-grid">
            @foreach($users as $user)
                <div class="project-card">
                    <div class="project-header">
                        <div>
                            <div class="project-name">{{ $user->name }}</div>
                            <div class="project-description">{{ $user->email }}</div>
                        </div>
                        <div class="project-status {{ $user->is_admin ? 'status-completed' : 'status-active' }}">
                            {{ $user->is_admin ? 'Admin' : 'Foydalanuvchi' }}
                        </div>
                    </div>
                    <div class="project-footer">
                        <small>
                            Jami vazifalar: {{ $user->total_tasks }}<br>
                            Tugallangan: {{ $user->completed_tasks }}<br>
                            Kechikkan: {{ $user->overdue_tasks }}<br>
                            Jarimalar: {{ number_format($user->total_penalties) }} so'm
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>