<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">Hisobotlar</h3>
    </div>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $reports['total_projects'] }}</h3>
            <p>Jami loyihalar</p>
            <div class="icon"><i class="fas fa-project-diagram"></i></div>
        </div>
        <div class="stat-card">
            <h3>{{ $reports['total_tasks'] }}</h3>
            <p>Jami vazifalar</p>
            <div class="icon"><i class="fas fa-tasks"></i></div>
        </div>
        <div class="stat-card">
            <h3>{{ $reports['completed_tasks'] }}</h3>
            <p>Tugallangan vazifalar</p>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-card">
            <h3>{{ $reports['overdue_tasks'] }}</h3>
            <p>Kechikkan vazifalar</p>
            <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
    </div>
</div>