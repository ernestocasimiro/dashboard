<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configurações - Pitruca Camama</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/settings.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
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
              <li class="has-submenu" data-tab="staff-management">
                  <div class="menu-item">
                      <i class="fas fa-chalkboard-teacher"></i> 
                      <span>Gestão de Funcionários</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="register-teachers">
                          <a href="teacher.php">
                              <i class="fas fa-user-plus"></i> 
                              <span>Professores/Coordenadores</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Utilizadores -->
              <li class="has-submenu" data-tab="users">
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
              <li class="active" data-tab="settings">
                  <a href="settings.php">
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
                  <input type="text" placeholder="Pesquisar configurações...">
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
              <div class="tab-pane active" id="settings">
                  <div class="settings-header">
                      <h2>Configurações do Sistema</h2>
                      <div class="settings-actions">
                          <button class="btn-save-all"><i class="fas fa-save"></i> Salvar Todas as Alterações</button>
                      </div>
                  </div>
                  
                  <div class="settings-container">
                      <div class="settings-sidebar">
                          <div class="settings-nav">
                              <button class="settings-nav-item active" data-section="school-info">
                                  <i class="fas fa-school"></i> Informações da Escola
                              </button>
                              <button class="settings-nav-item" data-section="users-permissions">
                                  <i class="fas fa-user-shield"></i> Usuários e Permissões
                              </button>
                              <button class="settings-nav-item" data-section="academic-settings">
                                  <i class="fas fa-graduation-cap"></i> Configurações Acadêmicas
                              </button>
                              <button class="settings-nav-item" data-section="notifications">
                                  <i class="fas fa-bell"></i> Notificações
                              </button>
                              <button class="settings-nav-item" data-section="appearance">
                                  <i class="fas fa-palette"></i> Aparência
                              </button>
                              <button class="settings-nav-item" data-section="system">
                                  <i class="fas fa-server"></i> Sistema
                              </button>
                          </div>
                      </div>
                      
                      <div class="settings-content">
                          <!-- Informações da Escola -->
                          <div class="settings-section active" id="school-info">
                              <div class="section-header">
                                  <h3>Informações da Escola</h3>
                                  <button class="btn-save-section"><i class="fas fa-save"></i> Salvar</button>
                              </div>
                              
                              <div class="settings-form">
                                  <div class="form-group">
                                      <label for="schoolName">Nome da Escola</label>
                                      <input type="text" id="schoolName" value="Pitruca Camama">
                                  </div>
                                  
                                  <div class="form-row">
                                      <div class="form-group">
                                          <label for="schoolPhone">Telefone</label>
                                          <input type="tel" id="schoolPhone" value="+244 923 456 789">
                                      </div>
                                      <div class="form-group">
                                          <label for="schoolEmail">E-mail</label>
                                          <input type="email" id="schoolEmail" value="contato@pitrucacamama.edu.ao">
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="schoolAddress">Endereço</label>
                                      <textarea id="schoolAddress" rows="3">Rua Principal, Bairro Camama, Luanda, Angola</textarea>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Logo da Escola</label>
                                      <div class="logo-upload">
                                          <div class="current-logo">
                                              <img src="login/images/semft-removebg-preview.png" alt="Logo da Escola">
                                          </div>
                                          <div class="logo-actions">
                                              <button class="btn-upload"><i class="fas fa-upload"></i> Carregar Nova</button>
                                              <button class="btn-remove"><i class="fas fa-trash"></i> Remover</button>
                                          </div>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="schoolDescription">Descrição</label>
                                      <textarea id="schoolDescription" rows="5">A Escola Pitruca Camama é uma instituição de ensino comprometida com a excelência educacional e o desenvolvimento integral dos alunos.</textarea>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="schoolDirector">Diretor(a)</label>
                                      <input type="text" id="schoolDirector" value="Ana Maria Silva">
                                  </div>
                                  
                                  <div class="form-row">
                                      <div class="form-group">
                                          <label for="foundationYear">Ano de Fundação</label>
                                          <input type="number" id="foundationYear" value="2005">
                                      </div>
                                      <div class="form-group">
                                          <label for="schoolType">Tipo de Instituição</label>
                                          <select id="schoolType">
                                              <option value="public">Pública</option>
                                              <option value="private" selected>Privada</option>
                                              <option value="mixed">Mista</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Usuários e Permissões -->
                          <div class="settings-section" id="users-permissions">
                              <div class="section-header">
                                  <h3>Usuários e Permissões</h3>
                                  <button class="btn-save-section"><i class="fas fa-save"></i> Salvar</button>
                              </div>
                              
                              <div class="settings-form">
                                  <div class="form-tabs">
                                      <button class="form-tab active" data-tab="roles">Funções</button>
                                      <button class="form-tab" data-tab="permissions">Permissões</button>
                                      <button class="form-tab" data-tab="security">Segurança</button>
                                  </div>
                                  
                                  <div class="form-tab-content active" id="roles-tab">
                                      <div class="roles-list">
                                          <div class="role-item">
                                              <div class="role-header">
                                                  <h4>Administrador</h4>
                                                  <div class="role-actions">
                                                      <button class="btn-edit-role"><i class="fas fa-edit"></i></button>
                                                      <button class="btn-delete-role" disabled><i class="fas fa-trash"></i></button>
                                                  </div>
                                              </div>
                                              <div class="role-description">
                                                  <p>Acesso completo a todas as funcionalidades do sistema.</p>
                                              </div>
                                              <div class="role-users">
                                                  <span>3 usuários</span>
                                              </div>
                                          </div>
                                          
                                          <div class="role-item">
                                              <div class="role-header">
                                                  <h4>Diretor</h4>
                                                  <div class="role-actions">
                                                      <button class="btn-edit-role"><i class="fas fa-edit"></i></button>
                                                      <button class="btn-delete-role"><i class="fas fa-trash"></i></button>
                                                  </div>
                                              </div>
                                              <div class="role-description">
                                                  <p>Acesso a relatórios, configurações acadêmicas e gestão de funcionários.</p>
                                              </div>
                                              <div class="role-users">
                                                  <span>1 usuário</span>
                                              </div>
                                          </div>
                                          
                                          <div class="role-item">
                                              <div class="role-header">
                                                  <h4>Professor</h4>
                                                  <div class="role-actions">
                                                      <button class="btn-edit-role"><i class="fas fa-edit"></i></button>
                                                      <button class="btn-delete-role"><i class="fas fa-trash"></i></button>
                                                  </div>
                                              </div>
                                              <div class="role-description">
                                                  <p>Acesso a turmas, notas, presença e comunicação com alunos e pais.</p>
                                              </div>
                                              <div class="role-users">
                                                  <span>15 usuários</span>
                                              </div>
                                          </div>
                                          
                                          <div class="role-item">
                                              <div class="role-header">
                                                  <h4>Secretaria</h4>
                                                  <div class="role-actions">
                                                      <button class="btn-edit-role"><i class="fas fa-edit"></i></button>
                                                      <button class="btn-delete-role"><i class="fas fa-trash"></i></button>
                                                  </div>
                                              </div>
                                              <div class="role-description">
                                                  <p>Acesso a cadastro de alunos, matrículas e documentação.</p>
                                              </div>
                                              <div class="role-users">
                                                  <span>2 usuários</span>
                                              </div>
                                          </div>
                                      </div>
                                      
                                      <button class="btn-add-role"><i class="fas fa-plus"></i> Adicionar Nova Função</button>
                                  </div>
                                  
                                  <div class="form-tab-content" id="permissions-tab">
                                      <div class="permissions-matrix">
                                          <table>
                                              <thead>
                                                  <tr>
                                                      <th>Módulo/Recurso</th>
                                                      <th>Administrador</th>
                                                      <th>Diretor</th>
                                                      <th>Professor</th>
                                                      <th>Secretaria</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <tr>
                                                      <td>Painel</td>
                                                      <td><input type="checkbox" checked disabled></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox" checked></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Gestão de Alunos</td>
                                                      <td><input type="checkbox" checked disabled></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox" checked></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Gestão Pedagógica</td>
                                                      <td><input type="checkbox" checked disabled></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox"></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Gestão de Funcionários</td>
                                                      <td><input type="checkbox" checked disabled></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox"></td>
                                                      <td><input type="checkbox"></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Comunicação</td>
                                                      <td><input type="checkbox" checked disabled></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox" checked></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Finanças</td>
                                                      <td><input type="checkbox" checked disabled></td>
                                                      <td><input type="checkbox" checked></td>
                                                      <td><input type="checkbox"></td>
                                                      <td><input type="checkbox"></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Configurações</td>
                                                      <td><input type="checkbox" checked disabled></td>
                                                      <td><input type="checkbox"></td>
                                                      <td><input type="checkbox"></td>
                                                      <td><input type="checkbox"></td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  
                                  <div class="form-tab-content" id="security-tab">
                                      <div class="security-settings">
                                          <div class="form-group">
                                              <label for="passwordPolicy">Política de Senha</label>
                                              <select id="passwordPolicy">
                                                  <option value="basic">Básica (mínimo 6 caracteres)</option>
                                                  <option value="medium" selected>Média (mínimo 8 caracteres, letras e números)</option>
                                                  <option value="strong">Forte (mínimo 10 caracteres, letras, números e símbolos)</option>
                                              </select>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label for="passwordExpiry">Expiração de Senha</label>
                                              <select id="passwordExpiry">
                                                  <option value="never">Nunca</option>
                                                  <option value="30">30 dias</option>
                                                  <option value="60">60 dias</option>
                                                  <option value="90" selected>90 dias</option>
                                                  <option value="180">180 dias</option>
                                              </select>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label for="sessionTimeout">Tempo Limite de Sessão</label>
                                              <select id="sessionTimeout">
                                                  <option value="15">15 minutos</option>
                                                  <option value="30" selected>30 minutos</option>
                                                  <option value="60">1 hora</option>
                                                  <option value="120">2 horas</option>
                                                  <option value="240">4 horas</option>
                                              </select>
                                          </div>
                                          
                                          <div class="form-group checkbox-group">
                                              <label>
                                                  <input type="checkbox" checked> Ativar autenticação de dois fatores
                                              </label>
                                          </div>
                                          
                                          <div class="form-group checkbox-group">
                                              <label>
                                                  <input type="checkbox" checked> Bloquear conta após 5 tentativas de login malsucedidas
                                              </label>
                                          </div>
                                          
                                          <div class="form-group checkbox-group">
                                              <label>
                                                  <input type="checkbox" checked> Registrar atividades de login
                                              </label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Configurações Acadêmicas -->
                          <div class="settings-section" id="academic-settings">
                              <div class="section-header">
                                  <h3>Configurações Acadêmicas</h3>
                                  <button class="btn-save-section"><i class="fas fa-save"></i> Salvar</button>
                              </div>
                              
                              <div class="settings-form">
                                  <div class="form-group">
                                      <label for="academicYear">Ano Letivo Atual</label>
                                      <select id="academicYear">
                                          <option value="2022">2022</option>
                                          <option value="2023" selected>2023</option>
                                          <option value="2024">2024</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-row">
                                      <div class="form-group">
                                          <label for="startDate">Data de Início</label>
                                          <input type="date" id="startDate" value="2023-02-01">
                                      </div>
                                      <div class="form-group">
                                          <label for="endDate">Data de Término</label>
                                          <input type="date" id="endDate" value="2023-11-30">
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="gradingSystem">Sistema de Avaliação</label>
                                      <select id="gradingSystem">
                                          <option value="0-20" selected>0-20 (Padrão Angolano)</option>
                                          <option value="0-10">0-10</option>
                                          <option value="A-F">A-F (Letras)</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="passingGrade">Nota Mínima para Aprovação</label>
                                      <input type="number" id="passingGrade" value="10" min="0" max="20">
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="attendanceThreshold">Percentual Mínimo de Presença</label>
                                      <input type="number" id="attendanceThreshold" value="75" min="0" max="100">
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Períodos Acadêmicos</label>
                                      <div class="academic-periods">
                                          <div class="period-item">
                                              <div class="period-header">
                                                  <h4>1º Trimestre</h4>
                                                  <div class="period-dates">01/02/2023 - 30/04/2023</div>
                                                  <div class="period-actions">
                                                      <button class="btn-edit-period"><i class="fas fa-edit"></i></button>
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="period-item">
                                              <div class="period-header">
                                                  <h4>2º Trimestre</h4>
                                                  <div class="period-dates">01/05/2023 - 31/08/2023</div>
                                                  <div class="period-actions">
                                                      <button class="btn-edit-period"><i class="fas fa-edit"></i></button>
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="period-item">
                                              <div class="period-header">
                                                  <h4>3º Trimestre</h4>
                                                  <div class="period-dates">01/09/2023 - 30/11/2023</div>
                                                  <div class="period-actions">
                                                      <button class="btn-edit-period"><i class="fas fa-edit"></i></button>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <button class="btn-add-period"><i class="fas fa-plus"></i> Adicionar Período</button>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Notificações -->
                          <div class="settings-section" id="notifications">
                              <div class="section-header">
                                  <h3>Configurações de Notificações</h3>
                                  <button class="btn-save-section"><i class="fas fa-save"></i> Salvar</button>
                              </div>
                              
                              <div class="settings-form">
                                  <div class="form-group">
                                      <label>Métodos de Notificação</label>
                                      <div class="notification-methods">
                                          <div class="method-item">
                                              <div class="method-header">
                                                  <h4><i class="fas fa-envelope"></i> E-mail</h4>
                                                  <label class="switch">
                                                      <input type="checkbox" checked>
                                                      <span class="slider"></span>
                                                  </label>
                                              </div>
                                          </div>
                                          
                                          <div class="method-item">
                                              <div class="method-header">
                                                  <h4><i class="fas fa-sms"></i> SMS</h4>
                                                  <label class="switch">
                                                      <input type="checkbox" checked>
                                                      <span class="slider"></span>
                                                  </label>
                                              </div>
                                          </div>
                                          
                                          <div class="method-item">
                                              <div class="method-header">
                                                  <h4><i class="fas fa-bell"></i> Notificações no Sistema</h4>
                                                  <label class="switch">
                                                      <input type="checkbox" checked>
                                                      <span class="slider"></span>
                                                  </label>
                                              </div>
                                          </div>
                                          
                                          <div class="method-item">
                                              <div class="method-header">
                                                  <h4><i class="fab fa-whatsapp"></i> WhatsApp</h4>
                                                  <label class="switch">
                                                      <input type="checkbox">
                                                      <span class="slider"></span>
                                                  </label>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Eventos para Notificação</label>
                                      <div class="notification-events">
                                          <div class="event-group">
                                              <h4>Acadêmico</h4>
                                              <div class="event-items">
                                                  <label><input type="checkbox" checked> Notas Lançadas</label>
                                                  <label><input type="checkbox" checked> Faltas Registradas</label>
                                                  <label><input type="checkbox" checked> Boletins Disponíveis</label>
                                                  <label><input type="checkbox" checked> Calendário de Provas</label>
                                              </div>
                                          </div>
                                          
                                          <div class="event-group">
                                              <h4>Financeiro</h4>
                                              <div class="event-items">
                                                  <label><input type="checkbox" checked> Mensalidade Gerada</label>
                                                  <label><input type="checkbox" checked> Pagamento Confirmado</label>
                                                  <label><input type="checkbox" checked> Pagamento Atrasado</label>
                                                  <label><input type="checkbox"> Alterações em Valores</label>
                                              </div>
                                          </div>
                                          
                                          <div class="event-group">
                                              <h4>Comunicação</h4>
                                              <div class="event-items">
                                                  <label><input type="checkbox" checked> Novas Mensagens</label>
                                                  <label><input type="checkbox" checked> Novos Avisos</label>
                                                  <label><input type="checkbox" checked> Reuniões Agendadas</label>
                                                  <label><input type="checkbox" checked> Eventos Escolares</label>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="emailTemplate">Modelo de E-mail</label>
                                      <select id="emailTemplate">
                                          <option value="default" selected>Padrão</option>
                                          <option value="minimal">Minimalista</option>
                                          <option value="colorful">Colorido</option>
                                          <option value="custom">Personalizado</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="notificationFrequency">Frequência de Resumos</label>
                                      <select id="notificationFrequency">
                                          <option value="realtime">Tempo Real</option>
                                          <option value="daily" selected>Diário</option>
                                          <option value="weekly">Semanal</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Aparência -->
                          <div class="settings-section" id="appearance">
                              <div class="section-header">
                                  <h3>Configurações de Aparência</h3>
                                  <button class="btn-save-section"><i class="fas fa-save"></i> Salvar</button>
                              </div>
                              
                              <div class="settings-form">
                                  <div class="form-group">
                                      <label for="theme">Tema</label>
                                      <select id="theme">
                                          <option value="light" selected>Claro</option>
                                          <option value="dark">Escuro</option>
                                          <option value="auto">Automático (Baseado no Sistema)</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Cores Principais</label>
                                      <div class="color-picker">
                                          <div class="color-option">
                                              <label for="primaryColor">Cor Primária</label>
                                              <input type="color" id="primaryColor" value="#4caf50">
                                          </div>
                                          <div class="color-option">
                                              <label for="secondaryColor">Cor Secundária</label>
                                              <input type="color" id="secondaryColor" value="#2196f3">
                                          </div>
                                          <div class="color-option">
                                              <label for="accentColor">Cor de Destaque</label>
                                              <input type="color" id="accentColor" value="#ff9800">
                                          </div>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Imagem de Fundo do Login</label>
                                      <div class="background-preview">
                                          <img src="login/images/semft-removebg-preview.png" alt="Imagem de Fundo">
                                          <div class="background-actions">
                                              <button class="btn-upload"><i class="fas fa-upload"></i> Carregar Nova</button>
                                              <button class="btn-remove"><i class="fas fa-trash"></i> Remover</button>
                                          </div>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="fontFamily">Fonte</label>
                                      <select id="fontFamily">
                                          <option value="system" selected>Padrão do Sistema</option>
                                          <option value="roboto">Roboto</option>
                                          <option value="opensans">Open Sans</option>
                                          <option value="montserrat">Montserrat</option>
                                          <option value="lato">Lato</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="fontSize">Tamanho da Fonte</label>
                                      <select id="fontSize">
                                          <option value="small">Pequeno</option>
                                          <option value="medium" selected>Médio</option>
                                          <option value="large">Grande</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group checkbox-group">
                                      <label>
                                          <input type="checkbox" checked> Mostrar animações
                                      </label>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Sistema -->
                          <div class="settings-section" id="system">
                              <div class="section-header">
                                  <h3>Configurações do Sistema</h3>
                                  <button class="btn-save-section"><i class="fas fa-save"></i> Salvar</button>
                              </div>
                              
                              <div class="settings-form">
                                  <div class="form-group">
                                      <label for="language">Idioma do Sistema</label>
                                      <select id="language">
                                          <option value="pt" selected>Português</option>
                                          <option value="en">Inglês</option>
                                          <option value="es">Espanhol</option>
                                          <option value="fr">Francês</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="timezone">Fuso Horário</label>
                                      <select id="timezone">
                                          <option value="Africa/Luanda" selected>África/Luanda (GMT+1)</option>
                                          <option value="Europe/Lisbon">Europa/Lisboa (GMT+0)</option>
                                          <option value="America/Sao_Paulo">América/São Paulo (GMT-3)</option>
                                          <option value="UTC">UTC</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="dateFormat">Formato de Data</label>
                                      <select id="dateFormat">
                                          <option value="dd/mm/yyyy" selected>DD/MM/AAAA</option>
                                          <option value="mm/dd/yyyy">MM/DD/AAAA</option>
                                          <option value="yyyy-mm-dd">AAAA-MM-DD</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="currency">Moeda</label>
                                      <select id="currency">
                                          <option value="AOA" selected>Kwanza Angolano (AOA)</option>
                                          <option value="USD">Dólar Americano (USD)</option>
                                          <option value="EUR">Euro (EUR)</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Backup do Sistema</label>
                                      <div class="backup-options">
                                          <div class="backup-info">
                                              <p>Último backup: <strong>15/05/2023 08:30</strong></p>
                                          </div>
                                          <div class="backup-actions">
                                              <button class="btn-backup-now"><i class="fas fa-download"></i> Fazer Backup Agora</button>
                                              <button class="btn-restore"><i class="fas fa-upload"></i> Restaurar</button>
                                          </div>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="backupSchedule">Agendamento de Backup</label>
                                      <select id="backupSchedule">
                                          <option value="daily" selected>Diário</option>
                                          <option value="weekly">Semanal</option>
                                          <option value="monthly">Mensal</option>
                                          <option value="manual">Manual</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Logs do Sistema</label>
                                      <div class="logs-actions">
                                          <button class="btn-view-logs"><i class="fas fa-list"></i> Ver Logs</button>
                                          <button class="btn-download-logs"><i class="fas fa-download"></i> Baixar Logs</button>
                                          <button class="btn-clear-logs"><i class="fas fa-trash"></i> Limpar Logs</button>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group checkbox-group">
                                      <label>
                                          <input type="checkbox" checked> Ativar cache do sistema
                                      </label>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label>Manutenção</label>
                                      <div class="maintenance-options">
                                          <button class="btn-maintenance"><i class="fas fa-tools"></i> Modo de Manutenção</button>
                                          <button class="btn-optimize"><i class="fas fa-bolt"></i> Otimizar Sistema</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </main>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get the user dropdown element
      const userDropdown = document.querySelector('.user-dropdown');
      const dropdownMenu = document.querySelector('.dropdown-menu');
      
      // Toggle dropdown when username is clicked
      userDropdown.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show');
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(event) {
        if (!userDropdown.contains(event.target)) {
          dropdownMenu.classList.remove('show');
        }
      });
      
      // No special automatic display - dropdown only shows when clicked
    });
  </script>
  
  
  <script src="js/script.js"></script>
  <script src="js/settings.js"></script>
</body>
</html>

<?php } else {
    header("Location: ../login.php");
    exit;
} ?>
