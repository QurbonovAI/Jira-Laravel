   // Navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.dataset.section === 'dashboard') {
                    location.href = '{{ route("dashboard") }}';
                    return;
                }
                e.preventDefault();
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                const section = this.dataset.section;
                const titles = {
                    dashboard: 'Dashboard',
                    projects: 'Loyihalar',
                    tasks: 'Vazifalar',
                    team: 'Jamoa',
                    penalties: 'Jarimalar',
                    reports: 'Hisobotlar'
                };
                document.getElementById('page-title').textContent = titles[section] || 'Dashboard';
                loadContent(section);
            });
        });

        function loadContent(section) {
            const contentArea = document.getElementById('content-area');
            const routes = {
                projects: '{{ route("projects.index") }}',
                tasks: '{{ route("issues.index") }}',
                team: '{{ route("team.index") }}',
                penalties: '{{ route("penalties.index") }}',
                reports: '{{ route("reports.index") }}'
            };

            if (!routes[section]) {
                location.reload();
                return;
            }

            fetch(routes[section], {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.text())
                .then(html => {
                    contentArea.innerHTML = html;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    contentArea.innerHTML = `<div class="alert alert-danger">Xatolik: ${error.message}</div>`;
                });
        }

        // Modal Functions
        function openProjectModal() {
            document.getElementById('projectModal').style.display = 'flex';
            document.getElementById('projectForm').reset();
            clearErrors('project');
        }

        function closeProjectModal() {
            document.getElementById('projectModal').style.display = 'none';
        }

        function openIssueModal() {
            document.getElementById('issueModal').style.display = 'flex';
            document.getElementById('issueForm').reset();
            clearErrors('issue');
        }

        function closeIssueModal() {
            document.getElementById('issueModal').style.display = 'none';
        }

        function showPenaltyModal(userId = null, issueId = null) {
            if (!userId || !issueId) {
                alert('Foydalanuvchi yoki vazifa tanlanmadi!');
                return;
            }
            document.getElementById('penaltyModal').style.display = 'flex';
            document.getElementById('penaltyForm').reset();
            clearErrors('penalty');
            document.getElementById('penaltyUserId').value = userId;
            document.getElementById('penaltyIssueId').value = issueId;
        }

        function closePenaltyModal() {
            document.getElementById('penaltyModal').style.display = 'none';
        }

        function clearErrors(formPrefix) {
            const errorFields = document.querySelectorAll(`#${formPrefix}Form .error-message`);
            errorFields.forEach(field => field.textContent = '');
        }

        function completeIssue(id) {
            if (confirm('Vazifani tugallandi deb belgilashni xohlaysizmi?')) {
                fetch('{{ route("issues.complete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: `issue_id=${id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                            alert('Vazifa tugallandi!');
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Xatolik yuz berdi: ' + error.message);
                    });
            }
        }

        // Form Submission with AJAX for Project Creation
        document.getElementById('projectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeProjectModal();
                        location.reload();
                        alert('Loyiha muvaffaqiyatli yaratildi!');
                    } else {
                        clearErrors('project');
                        if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const errorField = document.getElementById(`project${key.charAt(0).toUpperCase() + key.slice(1)}Error`);
                                if (errorField) errorField.textContent = data.errors[key][0];
                            });
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Xatolik yuz berdi: ' + error.message);
                });
        });

        // Form Submission with AJAX for Project Deletion
        document.querySelectorAll('.delete-project-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!confirm('Loyihani o\'chirishni tasdiqlaysizmi?')) {
                    return;
                }
                const formData = new FormData(this);
                const projectId = this.dataset.projectId;
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Loyiha muvaffaqiyatli o\'chirildi!');
                            location.reload();
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Xatolik yuz berdi: ' + error.message);
                    });
            });
        });

        // Form Submission with AJAX for Issue
        document.getElementById('issueForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeIssueModal();
                        location.reload();
                        alert('Vazifa muvaffaqiyatli yaratildi!');
                    } else {
                        clearErrors('issue');
                        if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const errorField = document.getElementById(`issue${key.charAt(0).toUpperCase() + key.slice(1)}Error`);
                                if (errorField) errorField.textContent = data.errors[key][0];
                            });
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Xatolik yuz berdi: ' + error.message);
                });
        });

        // Form Submission with AJAX for Penalty
        document.getElementById('penaltyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closePenaltyModal();
                        location.reload();
                        alert('Jarima muvaffaqiyatli qo\'shildi!');
                    } else {
                        clearErrors('penalty');
                        if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const errorField = document.getElementById(`penalty${key.charAt(0).toUpperCase() + key.slice(1)}Error`);
                                if (errorField) errorField.textContent = data.errors[key][0];
                            });
                        } else {
                            alert('Xatolik: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Xatolik yuz berdi: ' + error.message);
                });
        });

        // Close modals on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                closeProjectModal();
                closeIssueModal();
                closePenaltyModal();
            }
        };