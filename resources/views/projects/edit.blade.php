<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Loyihani tahrirlash: {{ $project->name }}</h3>
    </div>
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Loyiha nomi</label>
            <input type="text" id="name" name="name" value="{{ $project->name }}" required>
            @error('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Tavsif</label>
            <textarea id="description" name="description" rows="4">{{ $project->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="status">Holat</label>
            <select id="status" name="status">
                <option value="active" {{ $project->status === 'active' ? 'selected' : '' }}>Faol</option>
                <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Tugallangan</option>
            </select>
        </div>
        <button type="submit" class="btn-primary" style="width: 100%;">Saqlash</button>
    </form>
</div>