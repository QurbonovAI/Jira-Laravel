{{-- resources/views/projects/edit.blade.php --}}
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Loyihani Tahrirlash - {{ $project->name }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
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
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .form-header i {
            font-size: 50px;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-header .project-name {
            font-size: 16px;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
        }

        .form-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
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
            color: #f093fb;
            width: 16px;
        }

        .form-group input,
        .form-group textarea {
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
        .form-group textarea:focus {
            outline: none;
            border-color: #f093fb;
            background: white;
            box-shadow: 0 0 0 4px rgba(240, 147, 251, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
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

        .status-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }

        .status-card {
            padding: 20px;
            border: 3px solid #e0e0e0;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8f9fa;
            position: relative;
        }

        .status-card:hover {
            border-color: #f093fb;
            background: white;
            transform: translateY(-2px);
        }

        .status-card.selected {
            border-color: #f093fb;
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
        }

        .status-card.selected::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 10px;
            color: #f093fb;
            font-size: 18px;
        }

        .status-card i {
            font-size: 32px;
            display: block;
            margin-bottom: 10px;
            color: #f093fb;
        }

        .status-card span {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            display: block;
        }

        .status-card small {
            font-size: 12px;
            color: #666;
            display: block;
            margin-top: 5px;
        }

        .char-counter {
            font-size: 12px;
            color: #999;
            text-align: right;
            margin-top: 5px;
        }

        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
        }

        .btn-save {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(240, 147, 251, 0.6);
        }

        .btn-cancel {
            background: #f1f3f5;
            color: #495057;
        }

        .btn-cancel:hover {
            background: #e9ecef;
        }

        .btn:active {
            transform: translateY(0);
        }

        .info-badge {
            background: #e7f5ff;
            border: 1px solid #74c0fc;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: start;
            gap: 10px;
        }

        .info-badge i {
            color: #228be6;
            font-size: 16px;
            margin-top: 2px;
        }

        .info-badge div {
            flex: 1;
        }

        .info-badge strong {
            color: #1864ab;
            display: block;
            margin-bottom: 4px;
        }

        .info-badge span {
            font-size: 13px;
            color: #495057;
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

        @media (max-width: 768px) {
            .form-container {
                margin: 10px;
            }

            .form-header {
                padding: 30px 20px;
            }

            .form-body {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 24px;
            }

            .button-group {
                grid-template-columns: 1fr;
            }

            .status-selector {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <i class="fas fa-edit"></i>
            <h2>Loyihani Tahrirlash</h2>
            <div class="project-name">{{ $project->name }}</div>
        </div>

        <form action="{{ route('projects.update', $project) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')
            
            <div class="form-body">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="info-badge">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Diqqat!</strong>
                        <span>O'zgartirishlar darhol qo'llaniladi. Barcha ma'lumotlarni to'g'ri kiriting.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-tag"></i>
                        Loyiha nomi
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $project->name) }}" 
                        required 
                        maxlength="100"
                    >
                    <div class="char-counter">
                        <span id="nameCounter">{{ strlen(old('name', $project->name)) }}</span>/100 belgi
                    </div>
                    @error('name')
                        <div class="error-message" style="display: flex;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">
                        <i class="fas fa-align-left"></i>
                        Tavsif
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        maxlength="500"
                    >{{ old('description', $project->description) }}</textarea>
                    <div class="char-counter">
                        <span id="descCounter">{{ strlen(old('description', $project->description)) }}</span>/500 belgi
                    </div>
                    @error('description')
                        <div class="error-message" style="display: flex;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-toggle-on"></i>
                        Loyiha holati
                    </label>
                    <input type="hidden" id="status" name="status" value="{{ old('status', $project->status) }}">
                    <div class="status-selector">
                        <div 
                            class="status-card {{ old('status', $project->status) === 'active' ? 'selected' : '' }}" 
                            data-value="active" 
                            onclick="selectStatus('active')"
                        >
                            <i class="fas fa-play-circle"></i>
                            <span>Faol</span>
                            <small>Ishlab turilmoqda</small>
                        </div>
                        <div 
                            class="status-card {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}" 
                            data-value="completed" 
                            onclick="selectStatus('completed')"
                        >
                            <i class="fas fa-check-circle"></i>
                            <span>Tugallangan</span>
                            <small>Loyiha yakunlangan</small>
                        </div>
                    </div>
                    @error('status')
                        <div class="error-message" style="display: flex;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="button-group">
                    <a href="{{ route('dashboard') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i>
                        Bekor qilish
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save"></i>
                        O'zgarishlarni saqlash
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const nameInput = document.getElementById('name');
        const descInput = document.getElementById('description');
        const nameCounter = document.getElementById('nameCounter');
        const descCounter = document.getElementById('descCounter');

        nameInput.addEventListener('input', function() {
            nameCounter.textContent = this.value.length;
        });

        descInput.addEventListener('input', function() {
            descCounter.textContent = this.value.length;
        });

        function selectStatus(status) {
            document.querySelectorAll('.status-card').forEach(card => {
                card.classList.remove('selected');
            });
            document.querySelector(`[data-value="${status}"]`).classList.add('selected');
            document.getElementById('status').value = status;
        }
    </script>
</body>
</html>