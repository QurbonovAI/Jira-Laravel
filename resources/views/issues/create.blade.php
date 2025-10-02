<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Yangi vazifa yaratish</h3>
    </div>
    <form action="{{ route('issues.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Vazifa nomi</label>
            <input type="text" id="title" name="title" required>
            @error('title')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Tavsif</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="project_id">Loyiha</label>
            <select id="project_id" name="project_id" required>
                <option value="">Loyihani tanlang</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
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
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="priority">Muhimlik darajasi</label>
            <select id="priority" name="priority">
                <option value="low">Past</option>
                <option value="medium" selected>O'rta</option>
                <option value="high">Yuqori</option>
                <option value="urgent">Shoshilinch</option>
            </select>
        </div>
        <div class="form-group">
            <label for="due_date">Tugash sanasi</label>
            <input type="date" id="due_date" name="due_date">
        </div>
        <div class="form-group">
            <label for="estimated_time">Taxminiy vaqt (soat)</label>
            <input type="number" id="estimated_time" name="estimated_time" min="0" value="0" required>
            @error('estimated_time')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn-primary" style="width: 100%;">Vazifa yaratish</button>
    </form>
</div>