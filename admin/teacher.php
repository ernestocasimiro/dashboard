<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor - Sistema de Gestão Escolar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/teacher.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
            transition: opacity 0.3s;
        }

        .alert-success {
            background-color: #28a745;
        }

        .alert-error {
            background-color: #dc3545;
        }

        .close-alert {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            margin-left: 15px;
        }

        .fade-out {
            opacity: 0;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .user-dropdown {
            position: relative;
            cursor: pointer;
        }
        
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 4px;
            padding: 8px 0;
            z-index: 1000;
            min-width: 150px;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-item {
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            text-decoration: none;
        }
        
        .dropdown-item:hover {
            background-color: #f5f5f5;
        }

        /* Estilo para o botão de visualizar */
        .view-btn {
            background-color: #17a2b8;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            margin-right: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .view-btn:hover {
            background-color: #138496;
        }

        /* Estilo para o modal de visualização */
        .view-modal .modal-content {
            max-width: 600px;
        }

        .teacher-details {
            margin-top: 20px;
        }

        .teacher-details h4 {
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: bold;
            width: 150px;
            flex-shrink: 0;
        }

        .detail-value {
            flex-grow: 1;
        }

        .students-list {
            margin-top: 20px;
        }

        .students-list h4 {
            margin-bottom: 10px;
        }

        .students-list ul {
            list-style-type: none;
            padding-left: 0;
        }

        .students-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Pitruca Camama</h2>
            </div>
            <ul class="nav-links">
                <!-- Painel (Visão Geral) -->
                <li data-tab="dashboard">
                    <a href="index.php">
                        <i class="fas fa-tachometer-alt"></i> 
                        <span>Painel</span>
                    </a>
                </li>
                
                <!-- Gestão De Alunos -->
                <li class="has-submenu" data-tab="student-management">
                    <div class="menu-item">
                        <i class="fas fa-user-graduate"></i> 
                        <span>Gestão De Alunos</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <li data-tab="register-students">
                            <a href="students.php">
                                <i class="fas fa-user-plus"></i> 
                                <span>Estudantes</span>
                            </a>
                        </li>
                        <li data-tab="attendance">
                            <a href="attendance.php">
                                <i class="fas fa-calendar-check"></i> 
                                <span>Presença</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Gestão Pedagógica -->
                <li class="has-submenu" data-tab="pedagogical-management">
                    <div class="menu-item">
                        <i class="fas fa-chalkboard"></i> 
                        <span>Gestão Pedagógica</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <li data-tab="classes">
                            <a href="classes.php">
                                <i class="fas fa-users"></i> 
                                <span>Turmas</span>
                            </a>
                        </li>
                        <li data-tab="schedule">
                            <a href="schedule.php">
                                <i class="fas fa-calendar-alt"></i> 
                                <span>Horários</span>
                            </a>
                        </li>
                        <li data-tab="tests">
                            <a href="tests.php">
                                <i class="fas fa-file-alt"></i> 
                                <span>Provas</span>
                            </a>
                        </li>
                        <li data-tab="bulletins">
                            <a href="bulletins.php">
                                <i class="fas fa-file-invoice"></i> 
                                <span>Boletins</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Gestão de Funcionários -->
                <li class="has-submenu active" data-tab="staff-management">
                    <div class="menu-item">
                        <i class="fas fa-chalkboard-teacher"></i> 
                        <span>Gestão de Funcionários</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu show">
                        <li class="active" data-tab="register-teachers">
                            <a href="teacher.php">
                                <i class="fas fa-user-plus"></i> 
                                <span>Professores</span>
                            </a>
                            <a href="coordinator.php">
                                <i class="fas fa-user-plus"></i> 
                                <span>Coordenadores</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Utilizadores -->
                <li class="has-submenu active" data-tab="users">
                    <div class="menu-item">
                        <i class="fas fa-users"></i> 
                        <span>Utilizadores</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <li data-tab="guardians">
                            <a href="guardians.php">
                                <i class="fas fa-user-friends"></i> 
                                <span>Encarregados</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Comunicação -->
                <li class="has-submenu" data-tab="communication">
                    <div class="menu-item">
                        <i class="fas fa-comments"></i> 
                        <span>Comunicação</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <li data-tab="messages">
                            <a href="messages.php">
                                <i class="fas fa-envelope"></i> 
                                <span>Mensagens</span>
                            </a>
                        </li>
                        <li data-tab="notice-board">
                            <a href="notices.php">
                                <i class="fas fa-bullhorn"></i> 
                                <span>Quadro de Avisos</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Finanças -->
                <li class="has-submenu" data-tab="finances">
                    <div class="menu-item">
                        <i class="fas fa-money-bill-wave"></i> 
                        <span>Finanças</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    <ul class="submenu">
                        <li data-tab="financial-management">
                            <a href="finances.php">
                                <i class="fas fa-chart-line"></i> 
                                <span>Gestão Financeira</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Configurações -->
                <li data-tab="settings">
                    <a href="settings.html">
                        <i class="fas fa-cog"></i> 
                        <span>Configurações</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <main class="content">
            <header>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Pesquisar..." id="search-input">
                </div>
                <div class="user-info">
                    <div class="user user-dropdown">
                        <img src="login/images/semft-removebg-preview.png" alt="" class="userOptions__avatar img-circle" width="42" height="42">
                        <span><?php echo $_SESSION['fname']; ?></span>
                        <div class="dropdown-menu">
                            <a href="/dashboardpitruca_copia/login/logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Sair
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <div class="tab-content">
                <!-- Gestão de Funcionários - Cadastrar Professores -->
                <div class="tab-pane active" id="register-teachers">
                    <div class="section-header">
                        <h2>Cadastrar Professor</h2>
                        <button class="add-btn" id="add-teacher-btn">
                            <i class="fas fa-plus"></i> Adicionar Professor
                        </button>
                    </div>
                    
                    <div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Username</th>
                <th>Contato</th>
                <th>Email</th>
                <th>Área de Atuação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="teacher-table-body">
            <!-- dados dos professores serão inseridos aqui -->
        </tbody>
    </table>
</div>

                    
                    <div class="pagination">
                        <button class="pagination-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <button class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </main>
    </div>
<!-- Modal para adicionar/editar professores -->
<div class="modal" id="teacher-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="teacher-modal-title">Adicionar Novo Professor</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="teacher-form">
                <input type="hidden" id="teacher-id">
                
                <!-- Informações Pessoais -->
                <fieldset>
                    <legend>Informações Pessoais</legend>
                    <div class="form-group">
                        <label for="fname">Primeiro Nome <span class="required">*</span></label>
                        <input type="text" id="fname" placeholder="Primeiro nome do professor" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Último Nome <span class="required">*</span></label>
                        <input type="text" id="lname" placeholder="Último nome do professor" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="teacher-gender">Gênero <span class="required">*</span></label>
                            <select id="teacher-gender" required>
                                <option value="">Selecionar Gênero</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="teacher-dob">Data de Nascimento</label>
                            <input type="date" id="teacher-dob" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bi-number">Número do Bilhete de Identidade (BI)</label>
                        <input type="text" id="bi-number" placeholder="Ex: 0000000LA000" required pattern="^\d{7}[A-Za-z]{2}\d{3}$" title="O BI deve seguir o formato: 0000000LA000">
                    </div>
                    
                    <div class="form-group">
                        <label for="teacher-address">Endereço</label>
                        <textarea id="teacher-address" rows="2" placeholder="Endereço completo"></textarea>
                    </div>
                </fieldset>

                <!-- Informações de Contato -->
                <fieldset>
                    <legend>Informações de Contato</legend>
                    <div class="form-group">
                        <label for="teacher-contact">Número de Contato <span class="required">*</span></label>
                        <div class="phone-input-container">
                            <select id="country-code" class="country-code">
                                <option value="+244">+244 (Angola)</option>
                                <option value="+351">+351 (Portugal)</option>
                                <!-- Outros códigos... -->
                            </select>
                            <input type="tel" id="teacher-contact" placeholder="XXX XXX XXX" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="teacher-email">Email</label>
                        <input type="email" id="teacher-email" placeholder="exemplo@email.com">
                    </div>
                </fieldset>

                <!-- Informações de Acesso -->
                <fieldset>
                    <legend>Informações de Acesso</legend>
                    <div class="form-group">
                        <label for="teacher-username">Nome de Usuário <span class="required">*</span></label>
                        <input type="text" id="teacher-username" placeholder="Nome de usuário" required>
                    </div>
                    <div class="form-group">
                        <label for="teacher-password">Palavra-passe <span class="required">*</span></label>
                        <input type="password" id="teacher-password" placeholder="Crie uma palavra-passe segura" required
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                               title="A palavra-passe deve conter pelo menos: 8 caracteres, 1 letra maiúscula, 1 letra minúscula e 1 número">
                        <small class="password-requirements">
                            Requisitos: mínimo 8 caracteres, incluindo pelo menos 1 letra maiúscula, 1 letra minúscula e 1 número
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="teacher-confirm-password">Confirmar Palavra-passe <span class="required">*</span></label>
                        <input type="password" id="teacher-confirm-password" placeholder="Repita a palavra-passe" required>
                        <small id="password-match-error" style="color: red; display: none;">As palavras-passe não coincidem</small>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="button" class="cancel-btn" id="cancel-teacher-btn">Cancelar</button>
                    <button type="submit" class="save-btn">Salvar professor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Função para verificar se o professor tem pelo menos 18 anos
    document.getElementById("teacher-form").addEventListener("submit", function(event) {
        const dob = document.getElementById("teacher-dob").value;
        const biNumber = document.getElementById("bi-number").value;
        
        // Verifica se a data de nascimento foi preenchida
        if (dob) {
            const birthDate = new Date(dob);
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 18) {
                alert("O professor precisa ter pelo menos 18 anos.");
                event.preventDefault(); // Impede o envio do formulário
                return;
            }
        }

        // Valida o número do BI (com base no padrão)
        const biRegex = /^\d{7}[A-Za-z]{2}\d{3}$/;
        if (!biRegex.test(biNumber)) {
            alert("O número do Bilhete de Identidade (BI) não segue o formato correto.");
            event.preventDefault(); // Impede o envio do formulário
            return;
        }
    });
</script>

    <!-- Modal para visualizar detalhes do professor -->
    <div class="modal view-modal" id="view-teacher-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detalhes do professor</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="teacher-details">
                    <h4>Informações Pessoais</h4>
                    <div class="detail-row">
                        <div class="detail-label">Nome:</div>
                        <div class="detail-value" id="view-name"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Gênero:</div>
                        <div class="detail-value" id="view-gender"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Data de Nascimento:</div>
                        <div class="detail-value" id="view-dob"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">BI:</div>
                        <div class="detail-value" id="view-bi"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Endereço:</div>
                        <div class="detail-value" id="view-address"></div>
                    </div>
                    
                    <h4>Informações de Contato</h4>
                    <div class="detail-row">
                        <div class="detail-label">Contato:</div>
                        <div class="detail-value" id="view-contact"></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email:</div>
                        <div class="detail-value" id="view-email"></div>
                    </div>
                    
                    <div class="students-list">
                        <h4>Educandos</h4>
                        <ul id="view-students"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerta para notificações -->
    <div id="alert-container"></div>

    <script>
    // Função para mostrar alerta
    function showAlert(message, type = 'success') {
        const alertContainer = document.getElementById('alert-container');
        const alertId = 'alert-' + Date.now();
        
        const alertHTML = `
            <div id="${alertId}" class="alert alert-${type}">
                <span>${message}</span>
                <button class="close-alert">&times;</button>
            </div>
        `;
        
        alertContainer.insertAdjacentHTML('beforeend', alertHTML);
        
        const alertElement = document.getElementById(alertId);
        
        // Fechar alerta ao clicar no botão de fechar
        alertElement.querySelector('.close-alert').addEventListener('click', function() {
            alertElement.classList.add('fade-out');
            setTimeout(() => {
                alertElement.remove();
            }, 300);
        });
        
        // Fechar automaticamente após 5 segundos
        setTimeout(() => {
            if (alertElement) {
                alertElement.classList.add('fade-out');
                setTimeout(() => {
                    if (alertElement.parentNode) {
                        alertElement.remove();
                    }
                }, 300);
            }
        }, 5000);
    }

    // Função para carregar os professores
    function loadteachers() {
        fetch('api/teachers.php?action=get')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const teachersList = data.data;
                    let html = '';
                    teachersList.forEach(teacher => {
                        html += `
                            <tr>
                                <td>${teacher.id}</td>
                                <td>${teacher.fname} ${teacher.lname}</td>
                                <td>${teacher.username}</td>
                                <td>${teacher.contact}</td>
                                <td>${teacher.email}</td>
                                <td>${teacher.area}</td>
                                <td>
                                    <button class="view-btn" data-id="${teacher.id}"><i class="fas fa-eye"></i> Ver</button>
                                    <button class="edit-btn" data-id="${teacher.id}"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="delete-btn" data-id="${teacher.id}"><i class="fas fa-trash"></i> Excluir</button>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById('teacher-table-body').innerHTML = html;
                    
                    // Adicionar event listeners para os botões
                    setupActionButtons();
                } else {
                    showAlert('Erro ao carregar os dados: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao conectar com o servidor', 'error');
            });
    }

    // Configurar event listeners para os botões de ação
    function setupActionButtons() {
        // Botão de visualizar
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                viewteacher(id);
            });
        });
        
        // Botão de editar
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                editteacher(id);
            });
        });
        
        // Botão de excluir
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                deleteteacher(id);
            });
        });
    }

    // Função para visualizar um professor
    function viewteacher(id) {
        fetch(`api/teachers.php?action=getById&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const teacher = data.data;
                    
                    // Preencher os campos do modal de visualização
                    document.getElementById('view-name').textContent = `${teacher.fname} ${teacher.lname}` || 'N/A';
                    document.getElementById('view-gender').textContent = teacher.gender || 'N/A';
                    document.getElementById('view-dob').textContent = teacher.dob ? new Date(teacher.dob).toLocaleDateString() : 'N/A';
                    document.getElementById('view-bi').textContent = teacher.bi_number || 'N/A';
                    document.getElementById('view-address').textContent = teacher.address || 'N/A';
                    document.getElementById('view-contact').textContent = teacher.contact || 'N/A';
                    document.getElementById('view-email').textContent = teacher.email || 'N/A';
                    
                    // Preencher a lista de educandos
                    const studentsList = document.getElementById('view-students');
                    studentsList.innerHTML = '';
                    
                    if (teacher.students && teacher.students.length > 0) {
                        teacher.students.forEach(student => {
                            const li = document.createElement('li');
                            li.textContent = student.name;
                            studentsList.appendChild(li);
                        });
                    } else {
                        const li = document.createElement('li');
                        li.textContent = 'Nenhum educando associado';
                        studentsList.appendChild(li);
                    }
                    
                    // Mostrar o modal
                    document.getElementById('view-teacher-modal').style.display = 'block';
                } else {
                    showAlert('Erro ao carregar os dados do professor: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao conectar com o servidor', 'error');
            });
    }

    // Função para editar um professor
    function editteacher(id) {
        fetch(`api/teachers.php?action=getById&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const teacher = data.data;
                    
                    // Preencher os campos do formulário
                    document.getElementById('teacher-id').value = teacher.id;
                    document.getElementById('fname').value = teacher.fname || '';
                    document.getElementById('lname').value = teacher.lname || '';
                    document.getElementById('teacher-gender').value = teacher.gender || '';
                    document.getElementById('teacher-dob').value = teacher.dob || '';
                    document.getElementById('bi-number').value = teacher.bi_number || '';
                    document.getElementById('teacher-address').value = teacher.address || '';
                    
                    // Separar o código do país e o número de telefone
                    let contact = teacher.contact || '';
                    let countryCode = '+244'; // Padrão para Angola
                    let phoneNumber = contact;
                    
                    if (contact.startsWith('+')) {
                        const codeEnd = contact.indexOf(' ') > -1 ? contact.indexOf(' ') : 4;
                        countryCode = contact.substring(0, codeEnd);
                        phoneNumber = contact.substring(codeEnd).trim();
                    }
                    
                    document.getElementById('country-code').value = countryCode;
                    document.getElementById('teacher-contact').value = phoneNumber;
                    document.getElementById('teacher-email').value = teacher.email || '';
                    document.getElementById('teacher-username').value = teacher.username || '';
                    
                    // Atualizar o título do modal
                    document.getElementById('teacher-modal-title').textContent = 'Editar professor';
                    
                    // Mostrar o modal
                    document.getElementById('teacher-modal').style.display = 'block';
                } else {
                    showAlert('Erro ao carregar os dados do professor: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showAlert('Erro ao conectar com o servidor', 'error');
            });
    }

    // Função para excluir um professor
    function deleteteacher(id) {
        if (confirm('Tem certeza que deseja excluir este professor?')) {
            fetch(`api/teachers.php?action=delete&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Professor excluído com sucesso!');
                        loadteachers(); // Recarregar a lista
                    } else {
                        showAlert('Erro ao excluir professor: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showAlert('Erro ao conectar com o servidor', 'error');
                });
        }
    }

    // Event listener para o formulário de professor
    document.getElementById('teacher-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
       // Validação de senha
    const password = document.getElementById('teacher-password').value;
    const confirmPassword = document.getElementById('teacher-confirm-password').value;
    
    if (password !== confirmPassword) {
        showAlert('As senhas não coincidem', 'error');
        return;
    }

    // Validação de campos obrigatórios
    const fname = document.getElementById('fname').value.trim();
    const lname = document.getElementById('lname').value.trim();
    
    if (!fname || !lname) {
        showAlert('Primeiro nome e último nome são obrigatórios', 'error');
        return;
    }

        // Validação de idade
        const dob = new Date(document.getElementById('teacher-dob').value);
        const age = new Date().getFullYear() - dob.getFullYear();
        if (age < 18) {
            showAlert('O professor precisa ter pelo menos 18 anos', 'error');
            return;
        }

        // Validação do BI
        const biNumber = document.getElementById('bi-number').value;
        if (!/^\d{7}[A-Za-z]{2}\d{3}$/.test(biNumber)) {
            showAlert('O número do BI não segue o formato correto (0000000LA000)', 'error');
            return;
        }

        // Preparar dados do formulário
        const formData = {
            fname: document.getElementById('fname').value.trim(),
            lname: document.getElementById('lname').value.trim(),
            username: document.getElementById('teacher-username').value.trim(),
            gender: document.getElementById('teacher-gender').value,
            dob: document.getElementById('teacher-dob').value,
            bi_number: biNumber,
            address: document.getElementById('teacher-address').value.trim(),
            contact: document.getElementById('country-code').value + ' ' + 
                     document.getElementById('teacher-contact').value.trim(),
            email: document.getElementById('teacher-email').value.trim(),
            password: password
        };

        const teacherId = document.getElementById('teacher-id').value;
        const url = teacherId 
            ? `api/teachers.php?action=update&id=${teacherId}` 
            : 'api/teachers.php?action=create';
        
        // Enviar para o backend
        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(teacherId ? 'Professor atualizado com sucesso!' : 'Professor cadastrado com sucesso!');
                document.getElementById('teacher-modal').style.display = 'none';
                document.getElementById('teacher-form').reset();
                loadteachers(); // Recarregar a lista
            } else {
                showAlert('Erro: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showAlert('Erro ao conectar com o servidor', 'error');
        });
    });

    // Event listener para o botão de adicionar professor
    document.getElementById('add-teacher-btn').addEventListener('click', function() {
        // Limpar o formulário
        document.getElementById('teacher-form').reset();
        document.getElementById('teacher-id').value = '';
        
        // Atualizar o título do modal
        document.getElementById('teacher-modal-title').textContent = 'Adicionar Novo Professor';
        
        // Mostrar o modal
        document.getElementById('teacher-modal').style.display = 'block';
    });

    // Event listener para o botão de cancelar
    document.getElementById('cancel-teacher-btn').addEventListener('click', function() {
        document.getElementById('teacher-modal').style.display = 'none';
    });

    // Event listeners para fechar os modais
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.modal').style.display = 'none';
        });
    });

    // Fechar o modal ao clicar fora dele
    window.addEventListener('click', function(event) {
        document.querySelectorAll('.modal').forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Event listener para o dropdown do usuário
    document.querySelector('.user-dropdown').addEventListener('click', function(e) {
        e.stopPropagation();
        this.querySelector('.dropdown-menu').classList.toggle('show');
    });

    // Fechar o dropdown ao clicar fora dele
    document.addEventListener('click', function() {
        document.querySelector('.dropdown-menu').classList.remove('show');
    });

    // Event listener para o campo de pesquisa
    document.getElementById('search-input').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#teacher-table-body tr');
        
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const educando = row.cells[2].textContent.toLowerCase();
            const contact = row.cells[3].textContent.toLowerCase();
            
            if (name.includes(searchTerm) || educando.includes(searchTerm) || contact.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Funcionalidade da barra lateral
    document.querySelectorAll('.has-submenu .menu-item').forEach(item => {
        item.addEventListener('click', function() {
            const submenu = this.nextElementSibling;
            const isOpen = submenu.classList.contains('show');
            
            // Fechar todos os submenus
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.remove('show');
            });
            
            // Abrir o submenu clicado se estava fechado
            if (!isOpen) {
                submenu.classList.add('show');
            }
        });
    });

    // Carregar os professores ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        loadteachers();
    });
</script>
    </script>
</body>
</html>
<?php }else{
    header("Location: ../login.php");
    exit;
} ?>