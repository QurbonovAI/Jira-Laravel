{{-- resources/views/issues/create.blade.php --}}
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Yangi Vazifa Yaratish</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .form-header i {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .form-body {
            padding: 40px 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-grid .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group label i {
            margin-right: 8px;
            color: #4facfe;
            width: 16px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8f9fa;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4facfe;
            background: white;
            box-shadow: 0 0 0 4px rgba(79, 172, 254, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234facfe' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 45px;
        }

        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message i {
            font-size: 12px;
        }

        .priority-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .priority-option {
            padding: 12px 8px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8f9fa;
            position: relative;
        }

        .priority-option:hover {
            transform: translateY(-2px);
        }

        .priority-option.selected {
            border-width: 3px;
        }

        .priority-option i {
            font-size: 20px;
            display: block;
            margin-bottom: 5px;
        }

        .priority-option span {
            font-size: 12px;
            font-weight: 600;
            display: block;
        }

        .priority-option[data-priority="low"] {
            border-color: #51cf66;
        }

        .priority-option[data-priority="low"].selected {
            background: rgba(81, 207, 102, 0.1);
            border-color: #51cf66;
        }

        .priority-option[data-priority="low"] i {
            color: #51cf66;
        }

        .priority-option[data-priority="medium"] {
            border-color: #4facfe;
        }

        .priority-option[data-priority="medium"].selected {
            background: rgba(79, 172, 254, 0.1);
            border-color: #4facfe;
        }

        .priority-option[data-priority="medium"] i {
            color: #4facfe;
        }

        .priority-option[data-priority="high"] {
            border-color: #ffa94d;
        }

        .priority-option[data-priority="high"].selected {
            background: rgba(255, 169, 77, 0.1);
            border-color: #ffa94d;
        }

        .priority-option[data-priority="high"] i {
            color: #ffa94d;
        }

        .priority-option[data-priority="urgent"] {
            border-color: #ff6b6b;
        }

        .priority-option[data-priority="urgent"].selected {
            background: rgba(255, 107, 107, 0.1);
            border-color: #ff6b6b;
        }

        .priority-option[data-priority="urgent"] i {
            color: #ff6b6b;
        }

        .char-counter {
            font-size: 12px;
            color: #999;
            text-align: right;
            margin-top: 5px;
        }

        .button-group {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 16px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-cancel {
            background: #f1f3f5;
            color: #495057;
        }

        .btn-cancel:hover {
            background: #e9ecef;
        }

        .btn-submit {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.6);
        }

        .btn:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d3f9d8;
            border: 1px solid #8ce99a;
            color: #2b8a3e;
        }

        .alert-danger {
            background: #ffe3e3;
            border: 1px solid #ffa8a8;
            color: #c92a2a;
        }

        .time-input-wrapper {
            position: relative;
        }

        .time-input-wrapper .unit {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-header {
                padding: 30px 20px;
            }

            .form-body {
                padding: 30px 20px;
            }

            .priority-selector {
                grid-template-columns: repeat(2, 1fr);
            }

            .button-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <i class="fas fa-tasks"></i>
                <h2>Yangi Vazifa Yaratish</h2>
                <p>Loyihangiz uchun vazifa qo'shing</p>
            </div>

            <form action="{{ route('issues.store') }}" method="POST" id="issueForm">
                @csrf
                
                <div class="form-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="title">
                                <i class="fas fa-heading"></i>
                                Vazifa nomi
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                placeholder="Masalan: API integratsiyasi" 
                                required 
                                maxlength="255"
                            >
                            <div class="char-counter">
                                <span id="titleCounter">0</span>/255 belgi
                            </div>
                            @error('title')
                                <div class="error-message" style="display: flex;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="description">
                                <i class="fas fa-align-left"></i>
                                Tavsif
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                placeholder="Vazifa haqida batafsil ma'lumot..."
                                maxlength="1000"
                            >{{ old('description') }}</textarea>
                            <div class="char-counter">
                                <span id="descCounter">0</span>/1000 belgi
                            </div>
                            @error('description')
                                <div class="error-message" style="display: flex;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="project_id">
                                <i class="fas fa-project-diagram"></i>
                                Loyiha
                            </label>
                            <select id="project_id" name="project_id" required>
                                <option value="">Loyihani tanlang</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="error-message" style="display: flex;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="assignee_id">
                                <i class="fas fa-user"></i>
                                Mas'ul shaxs
                            </label>
                            <select id="assignee_id" name="assignee_id">
                                <option value="">Mas'ul shaxsni tanlang</option>
                                @if(isset($users) && $users->count() > 0)
                                    @foreach($users as $user)
                                        @if($user->is_active)
                                            <option value="{{ $user->id }}" {{ old('assignee_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} {{ $user->is_admin ? '(Admin)' : '' }}
                                            </option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="" disabled>Foydalanuvchilar topilmadi</option>
                                @endif
                            </select>
                            @error('assignee_id')
                                <div class="error-message" style="display: flex;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="due_date">
                                <i class="fas fa-calendar-alt"></i>
                                Tugash sanasi
                            </label>
                            <input 
                                type="date" 
                                id="due_date" 
                                name="due_date"
                                value="{{ old('due_date') }}"
                                min="{{ date('Y-m-d') }}"
                            >
                            @error('due_date')
                                <div class="error-message" style="display: flex;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="estimated_time">
                                <i class="fas fa-clock"></i>
                                Taxminiy vaqt
                            </label>
                            <div class="time-input-wrapper">
                                <input 
                                    type="number" 
                                    id="estimated_time" 
                                    name="estimated_time" 
                                    value="{{ old('estimated_time', 0) }}"
                                    min="0" 
                                    max="1000"
                                    required
                                    style="padding-right: 60px;"
                                >
                                <span class="unit">soat</span>
                            </div>
                            @error('estimated_time')
                                <div class="error-message" style="display: flex;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label>
                                <i class="fas fa-exclamation"></i>
                                Muhimlik darajasi
                            </label>
                            <input type="hidden" id="priority" name="priority" value="{{ old('priority', 'medium') }}">
                            <div class="priority-selector">
                                <div 
                                    class="priority-option {{ old('priority', 'medium') == 'low' ? 'selected' : '' }}" 
                                    data-priority="low" 
                                    onclick="selectPriority('low')"
                                >
                                    <i class="fas fa-arrow-down"></i>
                                    <span>Past</span>
                                </div>
                                <div 
                                    class="priority-option {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}" 
                                    data-priority="medium" 
                                    onclick="selectPriority('medium')"
                                >
                                    <i class="fas fa-minus"></i>
                                    <span>O'rta</span>
                                </div>
                                <div 
                                    class="priority-option {{ old('priority', 'medium') == 'high' ? 'selected' : '' }}" 
                                    data-priority="high" 
                                    onclick="selectPriority('high')"
                                >
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Yuqori</span>
                                </div>
                                <div 
                                    class="priority-option {{ old('priority', 'medium') == 'urgent' ? 'selected' : '' }}" 
                                    data-priority="urgent" 
                                    onclick="selectPriority('urgent')"
                                >
                                    <i class="fas fa-fire"></i>
                                    <span>Shoshilinch</span>
                                </div>
                            </div>
                            @error('priority')
                                <div class="error-message" style="display: flex;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('dashboard') }}" class="btn btn-cancel">
                            <i class="fas fa-times"></i>
                            Bekor qilish
                        </a>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-plus-circle"></i>
                            Vazifa yaratish
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const titleInput = document.getElementById('title');
        const descInput = document.getElementById('description');
        const titleCounter = document.getElementById('titleCounter');
        const descCounter = document.getElementById('descCounter');

        function updateCounters() {
            titleCounter.textContent = titleInput.value.length;
            descCounter.textContent = descInput.value.length;
        }

        titleInput.addEventListener('input', updateCounters);
        descInput.addEventListener('input', updateCounters);

        function selectPriority(priority) {
            document.querySelectorAll('.priority-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            document.querySelector(`[data-priority="${priority}"]`).classList.add('selected');
            document.getElementById('priority').value = priority;
        }

        updateCounters();
    </script>
</body>
</html>