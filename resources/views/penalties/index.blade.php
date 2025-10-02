<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Jarimalar</h3>
    </div>
    @if($penalties->isEmpty())
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="fas fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
            <p>Hozircha jarimalar yo'q.</p>
        </div>
    @else
        <ul class="task-list">
            @foreach($penalties as $penalty)
                <li class="task-item">
                    <div class="task-content">
                        <div class="task-title">Jarima: {{ number_format($penalty->amount) }} so'm</div>
                        <div class="task-meta">
                            Foydalanuvchi: {{ $penalty->user->name ?? 'N/A' }} •
                            Vazifa: {{ $penalty->issue->title ?? 'N/A' }} •
                            Sabab: {{ $penalty->reason }} •
                            Qo'llagan: {{ $penalty->appliedBy->name ?? 'N/A' }} •
                            {{ \Carbon\Carbon::parse($penalty->created_at)->format('d.m.Y') }}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>