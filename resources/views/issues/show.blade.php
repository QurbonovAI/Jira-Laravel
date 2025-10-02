<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">{{ $issue->title }}</h3>
    </div>
    <p>{{ $issue->description ?? 'Tavsif yo\'q' }}</p>
    <p><strong>Loyiha:</strong> {{ $issue->project->name ?? 'N/A' }}</p>
    <p><strong>Mas'ul:</strong> {{ $issue->assignee->name ?? 'Tayinlanmagan' }}</p>
    <p><strong>Yaratuvchi:</strong> {{ $issue->reporter->name ?? 'N/A' }}</p>
    <p><strong>Holat:</strong> {{ ['todo' => 'Boshlanmagan', 'in_progress' => 'Jarayonda', 'done' => 'Tugallangan'][$issue->status] ?? 'N/A' }}</p>
    <p><strong>Muhimlik:</strong> {{ ['high' => 'Yuqori', 'medium' => 'O\'rta', 'low' => 'Past', 'urgent' => 'Shoshilinch'][$issue->priority] ?? 'O\'rta' }}</p>
    <p><strong>Yaratilgan:</strong> {{ \Carbon\Carbon::parse($issue->created_at)->format('d.m.Y') }}</p>
    @if($issue->due_date)
        <p><strong>Tugash sanasi:</strong> {{ \Carbon\Carbon::parse($issue->due_date)->format('d.m.Y') }}
            @if(\Carbon\Carbon::parse($issue->due_date)->isPast() && $issue->status !== 'done')
                <span class="text-red-500"> (Kechikkan)</span>
            @endif
        </p>
    @endif
    <p><strong>Taxminiy vaqt:</strong> {{ $issue->estimated_time }} soat</p>
    <p><strong>Sarflangan vaqt:</strong> {{ $issue->spent_time ?? 0 }} soat</p>
    <div class="project-actions">
        <a href="{{ route('issues.edit', $issue) }}" class="btn-sm btn-edit">Tahrirlash</a>
        <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Vazifani o\'chirishni tasdiqlaysizmi?')">O'chirish</button>
        </form>
    </div>
</div>