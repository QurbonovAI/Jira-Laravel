@extends('layouts.app')

@section('content')
<div class="terminal-container unique-terminal">
    <div class="terminal-window">
        <div class="terminal-header unique-header">
            <span class="terminal-button red unique-red"></span>
            <span class="terminal-button yellow unique-yellow"></span>
            <span class="terminal-button green unique-green"></span>
            <div class="terminal-title">JIRA-Clone: Secure Access Terminal</div>
        </div>
        <div class="terminal-body unique-body">
            <div class="terminal-prompt unique-prompt">
                <span class="prompt-user">system@jira:~$</span>
                <span class="prompt-command">initiate_login_sequence</span>
            </div>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="terminal-input-group unique-group">
        <label class="terminal-label">identity_code [email]: </label>
        <input type="email" name="email" class="terminal-input unique-input" value="{{ old('email') }}" required autofocus placeholder="Enter identity code...">
        @error('email')
            <div class="terminal-error unique-error">{{ $message }}</div>
        @enderror
    </div>
    <div class="terminal-input-group unique-group">
        <label class="terminal-label">access_key [password]: </label>
        <input type="password" name="password" class="terminal-input unique-input" required placeholder="Enter access key...">
    </div>
    <div class="terminal-input-group unique-group">
        <button type="submit" class="terminal-submit unique-submit">> activate_protocol</button>
    </div>
</form>
            <div class="terminal-info unique-info">
                <p>[SYSTEM_LOG] Admin clearance required for new agent registration. Query admin node for access.</p>
            </div>
            <div class="terminal-scanline"></div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const prompt = document.querySelector('.prompt-command');
        const text = prompt.textContent;
        prompt.textContent = '';
        let i = 0;
        function type() {
            if (i < text.length) {
                prompt.textContent += text.charAt(i);
                i++;
                setTimeout(type, 100);
            }
        }
        type();
    });
</script>
@endsection