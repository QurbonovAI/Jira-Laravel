<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Yangi loyiha yaratish</h3>
    </div>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Loyiha nomi</label>
            <input type="text" id="name" name="name" required>
            @error('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Tavsif</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Holat</label>
            <select id="status" name="status">
                <option value="active">Faol</option>
                <option value="completed">Tugallangan</option>
            </select>
        </div>
        <button type="submit" class="btn-primary" style="width: 100%;">Loyiha yaratish</button>
    </form>
</div>