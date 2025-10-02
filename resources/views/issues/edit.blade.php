<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Vazifani tahrirlash: {{ $issue->title }}</h3>
    </div>
    <form action="{{ route('issues.update', $issue) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Vazifa nomi</label>
            <input type="text" id="title" name="title" value="{{ $issue->title }}" required>
            @error('title')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Tavsif</label>
            <textarea id="description" name="description" rows="4">{{ $issue->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="project_id">Loyiha</label>
            <select id="project_id" name="project_id" required>
                <option value="">Loyihani tanlang</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $issue->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
            @error('project_id')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="assignee_id">Mas'ul shaxs</label>
            <select id="assignee_id" name="assignee_id">
                <option value="">Mas'ul shaxsni tanlang</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $issue->assignee_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="priority">Muhimlik darajasi</label>
            <select id="priority" name="priority">
                <option value="low" {{ $issue->priority == 'low' ? 'selected' : '' }}>Past</option>
                <option value="medium" {{ $issue->priority == 'medium' ? 'selected' : '' }}>O'rta</option>
                <option value="high" {{ $issue->priority == 'high' ? 'selected' : '' }}>Yuqori</option>
                <option value="urgent" {{ $issue->priority == 'urgent' ? 'selected' : '' }}>Shoshilinch</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Holat</label>
            <select id="status" name="status">
                <option value="todo" {{ $issue->status == 'todo' ? 'selected' : '' }}>Boshlanmagan</option>
                <option value="in_progress" {{ $issue->status == 'in_progress' ? 'selected' : '' }}>Jarayonda</option>
                <option value="done" {{ $issue->status == 'done' ? 'selected' : '' }}>Tugallangan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="due_date">Tugash sanasi</label>
            <input type="date" id="due_date" name="due_date" value="{{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('Y-m-d') : '' }}">
        </div>
        <div class="form-group">
            <label for="estimated_time">Taxminiy vaqt (soat)</label>
            <input type="number" id="estimated_time" name="estimated_time" min="0" value="{{ $issue->estimated_time }}" required>
            @error('estimated_time')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="spent_time">Sarflangan vaqt (soat)</label>
            <input type="number" id="spent_time" name="spent_time" min="0" value="{{ $issue->spent_time ?? 0 }}">
        </div>
        <button type="submit" class="btn-primary" style="width: 100%;">Saqlash</button>
    </form>
</div>