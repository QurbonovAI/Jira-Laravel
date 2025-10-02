<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Barcha loyihalar</h3>
        @if(auth()->user()->is_admin)
            <a href="{{ route('projects.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Yangi loyiha
            </a>
        @endif
    </div>
    <div class="projects-grid">
        @if($projects->isEmpty())
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-project-diagram" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
                <p>Hozircha loyihalar yo'q. @if(auth()->user()->is_admin) Birinchi loyihangizni yarating! @else Admin loyiha yaratganda ko'rinadi. @endif</p>
            </div>
        @else
            @foreach($projects as $project)
                <div class="project-card">
                    <div class="project-header">
                        <div>
                            <div class="project-name">{{ $project->name }}</div>
                            <div class="project-description">{{ \Illuminate\Support\Str::limit($project->description ?? '', 100) }}</div>
                        </div>
                        <div class="project-status status-{{ $project->status ?? 'active' }}">
                            {{ $project->status === 'active' ? 'Faol' : 'Tugallangan' }}
                        </div>
                    </div>
                    <div class="project-footer">
                        <small>
                            Yaratuvchi: {{ $project->owner->name ?? 'N/A' }}<br>
                            {{ $project->created_at->format('d.m.Y') }}
                        </small>
                        <div class="project-actions">
                            <a href="{{ route('projects.show', $project) }}" class="btn-sm btn-view">Ko'rish</a>
                            @if(auth()->user()->is_admin || $project->owner_id == auth()->user()->id)
                                <a href="{{ route('projects.edit', $project) }}" class="btn-sm btn-edit">Tahrirlash</a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Loyihani o\'chirishni tasdiqlaysizmi?')">O'chirish</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>