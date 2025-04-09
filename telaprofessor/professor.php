<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Professor - Sistema de Gerenciamento Escolar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>EduManage</h2>
            </div>
            <div class="user-profile">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Foto do Professor">
                <div class="user-info">
                    <h3>Prof. Carlos Silva</h3>
                    <p>Matemática</p>
                </div>
            </div>
            <ul class="nav-links">
                <li class="active" data-tab="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
                <li data-tab="turmas"><i class="fas fa-users"></i> Minhas Turmas</li>
                <li data-tab="alunos"><i class="fas fa-user-graduate"></i> Alunos</li>
                <li data-tab="atividades"><i class="fas fa-tasks"></i> Atividades</li>
                <li data-tab="frequencia"><i class="fas fa-calendar-check"></i> Frequência</li>
                <li data-tab="notas"><i class="fas fa-chart-line"></i> Notas</li>
                <li data-tab="materiais"><i class="fas fa-book"></i> Materiais</li>
                <li data-tab="mensagens"><i class="fas fa-envelope"></i> Mensagens</li>
            </ul>
            <div class="logout">
                <i class="fas fa-sign-out-alt"></i> Sair
            </div>
        </nav>
        
        <main class="content">
            <header>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Pesquisar...">
                </div>
                <div class="user-info">
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="badge">5</span>
                    </div>
                    <div class="date-info">
                        <span id="current-date">Segunda-feira, 3 de Abril de 2025</span>
                    </div>
                </div>
            </header>
            
            <div class="tab-content">
                <!-- Dashboard Tab -->
                <div class="tab-pane active" id="dashboard">
                    <div class="welcome-header">
                        <h2>Bem-vindo, Prof. Carlos!</h2>
                        <p>Aqui está um resumo das suas atividades para hoje</p>
                    </div>
                    
                    <div class="stats-container">
                        <div class="stat-card">
                            <div class="stat-icon turma-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3>Turmas Ativas</h3>
                                <p>5</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon aluno-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="stat-info">
                                <h3>Total de Alunos</h3>
                                <p>127</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon atividade-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3>Atividades Pendentes</h3>
                                <p>8</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon hora-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <h3>Horas Lecionadas</h3>
                                <p>24h</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="quick-actions">
                        <h3>Ações Rápidas</h3>
                        <div class="action-buttons">
                            <button class="action-btn">
                                <i class="fas fa-plus-circle"></i>
                                <span>Criar Atividade</span>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-file-upload"></i>
                                <span>Enviar Material</span>
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-user-check"></i>
                                <span>Registrar Frequência</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="dashboard-grid">
                        <div class="dashboard-card aulas-hoje">
                            <div class="card-header">
                                <h3>Aulas de Hoje</h3>
                                <a href="#" class="view-all">Ver todas</a>
                            </div>
                            <div class="card-content">
                                <div class="aula-item">
                                    <div class="aula-time">08:00 - 09:40</div>
                                    <div class="aula-info">
                                        <h4>Matemática - Álgebra</h4>
                                        <p>2º Ano A - Sala 105</p>
                                    </div>
                                    <div class="aula-status ongoing">
                                        <span>Em andamento</span>
                                    </div>
                                </div>
                                <div class="aula-item">
                                    <div class="aula-time">10:00 - 11:40</div>
                                    <div class="aula-info">
                                        <h4>Matemática - Geometria</h4>
                                        <p>3º Ano B - Sala 203</p>
                                    </div>
                                    <div class="aula-status upcoming">
                                        <span>Próxima</span>
                                    </div>
                                </div>
                                <div class="aula-item">
                                    <div class="aula-time">13:30 - 15:10</div>
                                    <div class="aula-info">
                                        <h4>Matemática - Trigonometria</h4>
                                        <p>3º Ano A - Sala 201</p>
                                    </div>
                                    <div class="aula-status upcoming">
                                        <span>Próxima</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card atividades-corrigir">
                            <div class="card-header">
                                <h3>Atividades para Corrigir</h3>
                                <a href="#" class="view-all">Ver todas</a>
                            </div>
                            <div class="card-content">
                                <div class="atividade-item">
                                    <div class="atividade-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="atividade-info">
                                        <h4>Prova Bimestral - Funções</h4>
                                        <p>2º Ano A - Entregue em 01/04/2025</p>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: 65%"></div>
                                        </div>
                                        <span class="progress-text">65% corrigido</span>
                                    </div>
                                </div>
                                <div class="atividade-item">
                                    <div class="atividade-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="atividade-info">
                                        <h4>Trabalho - Geometria Espacial</h4>
                                        <p>3º Ano B - Entregue em 02/04/2025</p>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: 30%"></div>
                                        </div>
                                        <span class="progress-text">30% corrigido</span>
                                    </div>
                                </div>
                                <div class="atividade-item">
                                    <div class="atividade-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="atividade-info">
                                        <h4>Lista de Exercícios - Álgebra</h4>
                                        <p>1º Ano C - Entregue em 03/04/2025</p>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: 0%"></div>
                                        </div>
                                        <span class="progress-text">0% corrigido</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card desempenho-turmas">
                            <div class="card-header">
                                <h3>Desempenho das Turmas</h3>
                                <a href="#" class="view-all">Ver detalhes</a>
                            </div>
                            <div class="card-content">
                                <div class="turma-desempenho">
                                    <div class="turma-info">
                                        <h4>1º Ano C</h4>
                                        <div class="desempenho-bar">
                                            <div class="desempenho" style="width: 78%"></div>
                                        </div>
                                    </div>
                                    <div class="desempenho-valor">7.8</div>
                                </div>
                                <div class="turma-desempenho">
                                    <div class="turma-info">
                                        <h4>2º Ano A</h4>
                                        <div class="desempenho-bar">
                                            <div class="desempenho" style="width: 85%"></div>
                                        </div>
                                    </div>
                                    <div class="desempenho-valor">8.5</div>
                                </div>
                                <div class="turma-desempenho">
                                    <div class="turma-info">
                                        <h4>2º Ano B</h4>
                                        <div class="desempenho-bar">
                                            <div class="desempenho" style="width: 72%"></div>
                                        </div>
                                    </div>
                                    <div class="desempenho-valor">7.2</div>
                                </div>
                                <div class="turma-desempenho">
                                    <div class="turma-info">
                                        <h4>3º Ano A</h4>
                                        <div class="desempenho-bar">
                                            <div class="desempenho" style="width: 81%"></div>
                                        </div>
                                    </div>
                                    <div class="desempenho-valor">8.1</div>
                                </div>
                                <div class="turma-desempenho">
                                    <div class="turma-info">
                                        <h4>3º Ano B</h4>
                                        <div class="desempenho-bar">
                                            <div class="desempenho" style="width: 76%"></div>
                                        </div>
                                    </div>
                                    <div class="desempenho-valor">7.6</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card mensagens-recentes">
                            <div class="card-header">
                                <h3>Mensagens Recentes</h3>
                                <a href="#" class="view-all">Ver todas</a>
                            </div>
                            <div class="card-content">
                                <div class="mensagem-item unread">
                                    <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Foto do Remetente">
                                    <div class="mensagem-info">
                                        <h4>Maria Oliveira (Coordenadora)</h4>
                                        <p>Precisamos discutir o planejamento do próximo bimestre...</p>
                                        <span class="mensagem-time">Hoje, 09:45</span>
                                    </div>
                                </div>
                                <div class="mensagem-item unread">
                                    <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Foto do Remetente">
                                    <div class="mensagem-info">
                                        <h4>João Pedro (Aluno - 3º Ano A)</h4>
                                        <p>Professor, tenho uma dúvida sobre o exercício 5 da lista...</p>
                                        <span class="mensagem-time">Hoje, 08:30</span>
                                    </div>
                                </div>
                                <div class="mensagem-item">
                                    <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Foto do Remetente">
                                    <div class="mensagem-info">
                                        <h4>Ana Souza (Responsável)</h4>
                                        <p>Gostaria de agendar uma reunião para discutir o desempenho...</p>
                                        <span class="mensagem-time">Ontem, 16:20</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card calendario">
                            <div class="card-header">
                                <h3>Calendário Acadêmico</h3>
                                <a href="#" class="view-all">Ver completo</a>
                            </div>
                            <div class="card-content">
                                <div class="evento-item">
                                    <div class="evento-data">
                                        <span class="dia">10</span>
                                        <span class="mes">ABR</span>
                                    </div>
                                    <div class="evento-info">
                                        <h4>Conselho de Classe</h4>
                                        <p>14:00 - Sala dos Professores</p>
                                    </div>
                                </div>
                                <div class="evento-item">
                                    <div class="evento-data">
                                        <span class="dia">15</span>
                                        <span class="mes">ABR</span>
                                    </div>
                                    <div class="evento-info">
                                        <h4>Entrega de Notas</h4>
                                        <p>Prazo final para lançamento no sistema</p>
                                    </div>
                                </div>
                                <div class="evento-item">
                                    <div class="evento-data">
                                        <span class="dia">20</span>
                                        <span class="mes">ABR</span>
                                    </div>
                                    <div class="evento-info">
                                        <h4>Reunião de Pais</h4>
                                        <p>19:00 - Auditório Principal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card avisos">
                            <div class="card-header">
                                <h3>Avisos</h3>
                                <a href="#" class="view-all">Ver todos</a>
                            </div>
                            <div class="card-content">
                                <div class="aviso-item importante">
                                    <div class="aviso-icon">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="aviso-info">
                                        <h4>Atualização do Sistema</h4>
                                        <p>O sistema estará indisponível para manutenção no dia 05/04 das 22h às 02h.</p>
                                        <span class="aviso-time">02/04/2025</span>
                                    </div>
                                </div>
                                <div class="aviso-item">
                                    <div class="aviso-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="aviso-info">
                                        <h4>Novo Material Didático</h4>
                                        <p>Os novos livros didáticos já estão disponíveis na biblioteca para consulta.</p>
                                        <span class="aviso-time">01/04/2025</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Turmas Tab -->
                <div class="tab-pane" id="turmas">
                    <div class="section-header">
                        <h2>Gerenciamento de Turmas</h2>
                        <button class="add-btn" id="add-turma-btn">
                            <i class="fas fa-plus"></i> Nova Turma
                        </button>
                    </div>
                    
                    <div class="filter-controls">
                        <div class="search-filter">
                            <input type="text" id="turma-search" placeholder="Pesquisar turmas...">
                        </div>
                        <div class="dropdown-filter">
                            <select id="periodo-filter">
                                <option value="">Todos os Períodos</option>
                                <option value="matutino">Matutino</option>
                                <option value="vespertino">Vespertino</option>
                                <option value="noturno">Noturno</option>
                            </select>
                        </div>
                        <div class="dropdown-filter">
                            <select id="serie-filter">
                                <option value="">Todas as Séries</option>
                                <option value="1">1º Ano</option>
                                <option value="2">2º Ano</option>
                                <option value="3">3º Ano</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="turmas-grid">
                        <div class="turma-card">
                            <div class="turma-header">
                                <h3>1º Ano C</h3>
                                <span class="turma-periodo matutino">Matutino</span>
                            </div>
                            <div class="turma-body">
                                <div class="turma-info">
                                    <p><i class="fas fa-users"></i> <span>32 alunos</span></p>
                                    <p><i class="fas fa-clock"></i> <span>Segunda e Quarta, 08:00 - 09:40</span></p>
                                    <p><i class="fas fa-door-open"></i> <span>Sala 101</span></p>
                                </div>
                                <div class="turma-progresso">
                                    <h4>Progresso do Conteúdo</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 65%"></div>
                                    </div>
                                    <span class="progress-text">65% concluído</span>
                                </div>
                                <div class="turma-actions">
                                    <button class="action-btn view-turma"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-turma"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn attendance-turma"><i class="fas fa-user-check"></i> Frequência</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="turma-card">
                            <div class="turma-header">
                                <h3>2º Ano A</h3>
                                <span class="turma-periodo matutino">Matutino</span>
                            </div>
                            <div class="turma-body">
                                <div class="turma-info">
                                    <p><i class="fas fa-users"></i> <span>28 alunos</span></p>
                                    <p><i class="fas fa-clock"></i> <span>Terça e Quinta, 10:00 - 11:40</span></p>
                                    <p><i class="fas fa-door-open"></i> <span>Sala 105</span></p>
                                </div>
                                <div class="turma-progresso">
                                    <h4>Progresso do Conteúdo</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 70%"></div>
                                    </div>
                                    <span class="progress-text">70% concluído</span>
                                </div>
                                <div class="turma-actions">
                                    <button class="action-btn view-turma"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-turma"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn attendance-turma"><i class="fas fa-user-check"></i> Frequência</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="turma-card">
                            <div class="turma-header">
                                <h3>2º Ano B</h3>
                                <span class="turma-periodo vespertino">Vespertino</span>
                            </div>
                            <div class="turma-body">
                                <div class="turma-info">
                                    <p><i class="fas fa-users"></i> <span>30 alunos</span></p>
                                    <p><i class="fas fa-clock"></i> <span>Segunda e Quarta, 13:30 - 15:10</span></p>
                                    <p><i class="fas fa-door-open"></i> <span>Sala 203</span></p>
                                </div>
                                <div class="turma-progresso">
                                    <h4>Progresso do Conteúdo</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 60%"></div>
                                    </div>
                                    <span class="progress-text">60% concluído</span>
                                </div>
                                <div class="turma-actions">
                                    <button class="action-btn view-turma"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-turma"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn attendance-turma"><i class="fas fa-user-check"></i> Frequência</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="turma-card">
                            <div class="turma-header">
                                <h3>3º Ano A</h3>
                                <span class="turma-periodo matutino">Matutino</span>
                            </div>
                            <div class="turma-body">
                                <div class="turma-info">
                                    <p><i class="fas fa-users"></i> <span>25 alunos</span></p>
                                    <p><i class="fas fa-clock"></i> <span>Terça e Quinta, 08:00 - 09:40</span></p>
                                    <p><i class="fas fa-door-open"></i> <span>Sala 201</span></p>
                                </div>
                                <div class="turma-progresso">
                                    <h4>Progresso do Conteúdo</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 75%"></div>
                                    </div>
                                    <span class="progress-text">75% concluído</span>
                                </div>
                                <div class="turma-actions">
                                    <button class="action-btn view-turma"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-turma"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn attendance-turma"><i class="fas fa-user-check"></i> Frequência</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="turma-card">
                            <div class="turma-header">
                                <h3>3º Ano B</h3>
                                <span class="turma-periodo vespertino">Vespertino</span>
                            </div>
                            <div class="turma-body">
                                <div class="turma-info">
                                    <p><i class="fas fa-users"></i> <span>22 alunos</span></p>
                                    <p><i class="fas fa-clock"></i> <span>Segunda e Quarta, 15:30 - 17:10</span></p>
                                    <p><i class="fas fa-door-open"></i> <span>Sala 205</span></p>
                                </div>
                                <div class="turma-progresso">
                                    <h4>Progresso do Conteúdo</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 80%"></div>
                                    </div>
                                    <span class="progress-text">80% concluído</span>
                                </div>
                                <div class="turma-actions">
                                    <button class="action-btn view-turma"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-turma"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn attendance-turma"><i class="fas fa-user-check"></i> Frequência</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Alunos Tab -->
                <div class="tab-pane" id="alunos">
                    <div class="section-header">
                        <h2>Gerenciamento de Alunos</h2>
                        <div class="header-actions">
                            <button class="action-btn">
                                <i class="fas fa-file-export"></i> Exportar
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-envelope"></i> Enviar Mensagem
                            </button>
                        </div>
                    </div>
                    
                    <div class="filter-controls">
                        <div class="search-filter">
                            <input type="text" id="aluno-search" placeholder="Pesquisar alunos...">
                        </div>
                        <div class="dropdown-filter">
                            <select id="turma-filter">
                                <option value="">Todas as Turmas</option>
                                <option value="1c">1º Ano C</option>
                                <option value="2a">2º Ano A</option>
                                <option value="2b">2º Ano B</option>
                                <option value="3a">3º Ano A</option>
                                <option value="3b">3º Ano B</option>
                            </select>
                        </div>
                        <div class="dropdown-filter">
                            <select id="status-filter">
                                <option value="">Todos os Status</option>
                                <option value="regular">Regular</option>
                                <option value="atencao">Atenção</option>
                                <option value="recuperacao">Recuperação</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Turma</th>
                                    <th>Média</th>
                                    <th>Frequência</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A001</td>
                                    <td>Ana Beatriz Santos</td>
                                    <td>1º Ano C</td>
                                    <td>8.5</td>
                                    <td>95%</td>
                                    <td><span class="status-badge regular">Regular</span></td>
                                    <td>
                                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn message"><i class="fas fa-envelope"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A002</td>
                                    <td>Bruno Oliveira</td>
                                    <td>1º Ano C</td>
                                    <td>6.8</td>
                                    <td>88%</td>
                                    <td><span class="status-badge atencao">Atenção</span></td>
                                    <td>
                                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn message"><i class="fas fa-envelope"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A015</td>
                                    <td>Carlos Eduardo Silva</td>
                                    <td>2º Ano A</td>
                                    <td>9.2</td>
                                    <td>98%</td>
                                    <td><span class="status-badge regular">Regular</span></td>
                                    <td>
                                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn message"><i class="fas fa-envelope"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A023</td>
                                    <td>Daniela Costa</td>
                                    <td>2º Ano A</td>
                                    <td>7.5</td>
                                    <td>92%</td>
                                    <td><span class="status-badge regular">Regular</span></td>
                                    <td>
                                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn message"><i class="fas fa-envelope"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A031</td>
                                    <td>Eduardo Martins</td>
                                    <td>2º Ano B</td>
                                    <td>5.4</td>
                                    <td>78%</td>
                                    <td><span class="status-badge recuperacao">Recuperação</span></td>
                                    <td>
                                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn message"><i class="fas fa-envelope"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A042</td>
                                    <td>Fernanda Lima</td>
                                    <td>3º Ano A</td>
                                    <td>8.9</td>
                                    <td>96%</td>
                                    <td><span class="status-badge regular">Regular</span></td>
                                    <td>
                                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn message"><i class="fas fa-envelope"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>A055</td>
                                    <td>Gabriel Almeida</td>
                                    <td>3º Ano B</td>
                                    <td>6.2</td>
                                    <td>85%</td>
                                    <td><span class="status-badge atencao">Atenção</span></td>
                                    <td>
                                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn message"><i class="fas fa-envelope"></i></button>
                                    </td>
                                </tr>
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
                
                <!-- Atividades Tab -->
                <div class="tab-pane" id="atividades">
                    <div class="section-header">
                        <h2>Gerenciamento de Atividades</h2>
                        <button class="add-btn" id="add-atividade-btn">
                            <i class="fas fa-plus"></i> Nova Atividade
                        </button>
                    </div>
                    
                    <div class="filter-controls">
                        <div class="search-filter">
                            <input type="text" id="atividade-search" placeholder="Pesquisar atividades...">
                        </div>
                        <div class="dropdown-filter">
                            <select id="atividade-turma-filter">
                                <option value="">Todas as Turmas</option>
                                <option value="1c">1º Ano C</option>
                                <option value="2a">2º Ano A</option>
                                <option value="2b">2º Ano B</option>
                                <option value="3a">3º Ano A</option>
                                <option value="3b">3º Ano B</option>
                            </select>
                        </div>
                        <div class="dropdown-filter">
                            <select id="atividade-tipo-filter">
                                <option value="">Todos os Tipos</option>
                                <option value="prova">Prova</option>
                                <option value="trabalho">Trabalho</option>
                                <option value="exercicio">Exercício</option>
                                <option value="projeto">Projeto</option>
                            </select>
                        </div>
                        <div class="dropdown-filter">
                            <select id="atividade-status-filter">
                                <option value="">Todos os Status</option>
                                <option value="pendente">Pendente</option>
                                <option value="em-andamento">Em Andamento</option>
                                <option value="concluida">Concluída</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="atividades-grid">
                        <div class="atividade-card">
                            <div class="atividade-header prova">
                                <span class="atividade-tipo">Prova</span>
                                <h3>Prova Bimestral - Funções</h3>
                            </div>
                            <div class="atividade-body">
                                <div class="atividade-info">
                                    <p><i class="fas fa-users"></i> <span>2º Ano A</span></p>
                                    <p><i class="fas fa-calendar"></i> <span>Aplicada: 01/04/2025</span></p>
                                    <p><i class="fas fa-calendar-check"></i> <span>Prazo: 08/04/2025</span></p>
                                </div>
                                <div class="atividade-progresso">
                                    <h4>Progresso da Correção</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 65%"></div>
                                    </div>
                                    <span class="progress-text">18/28 corrigidas</span>
                                </div>
                                <div class="atividade-actions">
                                    <button class="action-btn view-atividade"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-atividade"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn grade-atividade"><i class="fas fa-check-circle"></i> Corrigir</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="atividade-card">
                            <div class="atividade-header trabalho">
                                <span class="atividade-tipo">Trabalho</span>
                                <h3>Trabalho - Geometria Espacial</h3>
                            </div>
                            <div class="atividade-body">
                                <div class="atividade-info">
                                    <p><i class="fas fa-users"></i> <span>3º Ano B</span></p>
                                    <p><i class="fas fa-calendar"></i> <span>Aplicada: 25/03/2025</span></p>
                                    <p><i class="fas fa-calendar-check"></i> <span>Prazo: 10/04/2025</span></p>
                                </div>
                                <div class="atividade-progresso">
                                    <h4>Progresso da Correção</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 30%"></div>
                                    </div>
                                    <span class="progress-text">6/22 corrigidas</span>
                                </div>
                                <div class="atividade-actions">
                                    <button class="action-btn view-atividade"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-atividade"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn grade-atividade"><i class="fas fa-check-circle"></i> Corrigir</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="atividade-card">
                            <div class="atividade-header exercicio">
                                <span class="atividade-tipo">Exercício</span>
                                <h3>Lista de Exercícios - Álgebra</h3>
                            </div>
                            <div class="atividade-body">
                                <div class="atividade-info">
                                    <p><i class="fas fa-users"></i> <span>1º Ano C</span></p>
                                    <p><i class="fas fa-calendar"></i> <span>Aplicada: 02/04/2025</span></p>
                                    <p><i class="fas fa-calendar-check"></i> <span>Prazo: 09/04/2025</span></p>
                                </div>
                                <div class="atividade-progresso">
                                    <h4>Progresso da Correção</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 0%"></div>
                                    </div>
                                    <span class="progress-text">0/32 corrigidas</span>
                                </div>
                                <div class="atividade-actions">
                                    <button class="action-btn view-atividade"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-atividade"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn grade-atividade"><i class="fas fa-check-circle"></i> Corrigir</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="atividade-card">
                            <div class="atividade-header projeto">
                                <span class="atividade-tipo">Projeto</span>
                                <h3>Projeto - Estatística Aplicada</h3>
                            </div>
                            <div class="atividade-body">
                                <div class="atividade-info">
                                    <p><i class="fas fa-users"></i> <span>3º Ano A</span></p>
                                    <p><i class="fas fa-calendar"></i> <span>Aplicada: 15/03/2025</span></p>
                                    <p><i class="fas fa-calendar-check"></i> <span>Prazo: 15/04/2025</span></p>
                                </div>
                                <div class="atividade-progresso">
                                    <h4>Progresso da Correção</h4>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: 20%"></div>
                                    </div>
                                    <span class="progress-text">5/25 corrigidas</span>
                                </div>
                                <div class="atividade-actions">
                                    <button class="action-btn view-atividade"><i class="fas fa-eye"></i> Detalhes</button>
                                    <button class="action-btn edit-atividade"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="action-btn grade-atividade"><i class="fas fa-check-circle"></i> Corrigir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Frequência Tab -->
                <div class="tab-pane" id="frequencia">
                    <div class="section-header">
                        <h2>Registro de Frequência</h2>
                        <button class="add-btn" id="registrar-frequencia-btn">
                            <i class="fas fa-user-check"></i> Registrar Frequência
                        </button>
                    </div>
                    
                    <div class="filter-controls">
                        <div class="dropdown-filter">
                            <select id="frequencia-turma-filter">
                                <option value="">Selecione a Turma</option>
                                <option value="1c">1º Ano C</option>
                                <option value="2a">2º Ano A</option>
                                <option value="2b">2º Ano B</option>
                                <option value="3a">3º Ano A</option>
                                <option value="3b">3º Ano B</option>
                            </select>
                        </div>
                        <div class="date-filter">
                            <input type="date" id="frequencia-data" value="2025-04-03">
                        </div>
                        <button class="action-btn" id="buscar-frequencia-btn">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                    
                    <div class="frequencia-container">
                        <div class="frequencia-header">
                            <h3>Frequência - 2º Ano A - 03/04/2025</h3>
                            <div class="frequencia-stats">
                                <span class="stat"><i class="fas fa-user-check"></i> Presentes: 25</span>
                                <span class="stat"><i class="fas fa-user-times"></i> Ausentes: 3</span>
                                <span class="stat"><i class="fas fa-percentage"></i> Taxa: 89%</span>
                            </div>
                        </div>
                        
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Status</th>
                                        <th>Observação</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A015</td>
                                        <td>Carlos Eduardo Silva</td>
                                        <td><span class="status-badge presente">Presente</span></td>
                                        <td></td>
                                        <td>
                                            <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A023</td>
                                        <td>Daniela Costa</td>
                                        <td><span class="status-badge presente">Presente</span></td>
                                        <td></td>
                                        <td>
                                            <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A024</td>
                                        <td>Enzo Fernandes</td>
                                        <td><span class="status-badge ausente">Ausente</span></td>
                                        <td>Atestado médico</td>
                                        <td>
                                            <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A025</td>
                                        <td>Gabriela Santos</td>
                                        <td><span class="status-badge presente">Presente</span></td>
                                        <td></td>
                                        <td>
                                            <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A026</td>
                                        <td>Henrique Oliveira</td>
                                        <td><span class="status-badge atrasado">Atrasado</span></td>
                                        <td>Chegou 15 minutos atrasado</td>
                                        <td>
                                            <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="frequencia-historico">
                        <h3>Histórico de Frequência - 2º Ano A</h3>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <div class="bar" style="height: 90%;" data-value="90%">
                                    <span>30/03</span>
                                </div>
                                <div class="bar" style="height: 95%;" data-value="95%">
                                    <span>31/03</span>
                                </div>
                                <div class="bar" style="height: 85%;" data-value="85%">
                                    <span>01/04</span>
                                </div>
                                <div class="bar" style="height: 92%;" data-value="92%">
                                    <span>02/04</span>
                                </div>
                                <div class="bar" style="height: 89%;" data-value="89%">
                                    <span>03/04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Notas Tab -->
                <div class="tab-pane" id="notas">
                    <div class="section-header">
                        <h2>Gerenciamento de Notas</h2>
                        <div class="header-actions">
                            <button class="action-btn">
                                <i class="fas fa-file-export"></i> Exportar
                            </button>
                            <button class="action-btn">
                                <i class="fas fa-calculator"></i> Calcular Médias
                            </button>
                        </div>
                    </div>
                    
                    <div class="filter-controls">
                        <div class="dropdown-filter">
                            <select id="notas-turma-filter">
                                <option value="">Selecione a Turma</option>
                                <option value="1c">1º Ano C</option>
                                <option value="2a" selected>2º Ano A</option>
                                <option value="2b">2º Ano B</option>
                                <option value="3a">3º Ano A</option>
                                <option value="3b">3º Ano B</option>
                            </select>
                        </div>
                        <div class="dropdown-filter">
                            <select id="notas-bimestre-filter">
                                <option value="1">1º Bimestre</option>
                                <option value="2" selected>2º Bimestre</option>
                                <option value="3">3º Bimestre</option>
                                <option value="4">4º Bimestre</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="notas-container">
                        <div class="notas-header">
                            <h3>Notas - 2º Ano A - 2º Bimestre</h3>
                            <div class="notas-stats">
                                <span class="stat"><i class="fas fa-chart-line"></i> Média da Turma: 7.8</span>
                                <span class="stat"><i class="fas fa-arrow-up"></i> Nota Máxima: 9.5</span>
                                <span class="stat"><i class="fas fa-arrow-down"></i> Nota Mínima: 5.2</span>
                            </div>
                        </div>
                        
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Prova 1 (40%)</th>
                                        <th>Trabalho (30%)</th>
                                        <th>Exercícios (20%)</th>
                                        <th>Participação (10%)</th>
                                        <th>Média</th>
                                        <th>Situação</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A015</td>
                                        <td>Carlos Eduardo Silva</td>
                                        <td><input type="number" class="nota-input" value="9.5" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="9.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="9.2" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="9.0" min="0" max="10" step="0.1"></td>
                                        <td>9.2</td>
                                        <td><span class="status-badge aprovado">Aprovado</span></td>
                                        <td>
                                            <button class="action-btn save"><i class="fas fa-save"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A023</td>
                                        <td>Daniela Costa</td>
                                        <td><input type="number" class="nota-input" value="7.5" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="8.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="7.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="8.5" min="0" max="10" step="0.1"></td>
                                        <td>7.6</td>
                                        <td><span class="status-badge aprovado">Aprovado</span></td>
                                        <td>
                                            <button class="action-btn save"><i class="fas fa-save"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A024</td>
                                        <td>Enzo Fernandes</td>
                                        <td><input type="number" class="nota-input" value="5.5" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="6.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="5.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="7.0" min="0" max="10" step="0.1"></td>
                                        <td>5.7</td>
                                        <td><span class="status-badge recuperacao">Recuperação</span></td>
                                        <td>
                                            <button class="action-btn save"><i class="fas fa-save"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A025</td>
                                        <td>Gabriela Santos</td>
                                        <td><input type="number" class="nota-input" value="8.5" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="9.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="8.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="9.5" min="0" max="10" step="0.1"></td>
                                        <td>8.6</td>
                                        <td><span class="status-badge aprovado">Aprovado</span></td>
                                        <td>
                                            <button class="action-btn save"><i class="fas fa-save"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A026</td>
                                        <td>Henrique Oliveira</td>
                                        <td><input type="number" class="nota-input" value="6.5" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="7.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="6.0" min="0" max="10" step="0.1"></td>
                                        <td><input type="number" class="nota-input" value="8.0" min="0" max="10" step="0.1"></td>
                                        <td>6.7</td>
                                        <td><span class="status-badge aprovado">Aprovado</span></td>
                                        <td>
                                            <button class="action-btn save"><i class="fas fa-save"></i></button>
                                            <button class="action-btn history"><i class="fas fa-history"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modal Nova Turma -->
    <div class="modal" id="turma-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Adicionar Nova Turma</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="turma-form">
                    <div class="form-group">
                        <label for="turma-nome">Nome da Turma</label>
                        <input type="text" id="turma-nome" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="turma-serie">Série</label>
                            <select id="turma-serie" required>
                                <option value="">Selecione</option>
                                <option value="1">1º Ano</option>
                                <option value="2">2º Ano</option>
                                <option value="3">3º Ano</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="turma-periodo">Período</label>
                            <select id="turma-periodo" required>
                                <option value="">Selecione</option>
                                <option value="matutino">Matutino</option>
                                <option value="vespertino">Vespertino</option>
                                <option value="noturno">Noturno</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="turma-sala">Sala</label>
                            <input type="text" id="turma-sala" required>
                        </div>
                        <div class="form-group">
                            <label for="turma-capacidade">Capacidade</label>
                            <input type="number" id="turma-capacidade" min="1" max="50" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="turma-horario">Horário</label>
                        <input type="text" id="turma-horario" placeholder="Ex: Segunda e Quarta, 08:00 - 09:40" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="cancel-btn">Cancelar</button>
                        <button type="submit" class="save-btn">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Nova Atividade -->
    <div class="modal" id="atividade-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Adicionar Nova Atividade</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="atividade-form">
                    <div class="form-group">
                        <label for="atividade-titulo">Título</label>
                        <input type="text" id="atividade-titulo" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="atividade-tipo">Tipo</label>
                            <select id="atividade-tipo" required>
                                <option value="">Selecione</option>
                                <option value="prova">Prova</option>
                                <option value="trabalho">Trabalho</option>
                                <option value="exercicio">Exercício</option>
                                <option value="projeto">Projeto</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="atividade-turma">Turma</label>
                            <select id="atividade-turma" required>
                                <option value="">Selecione</option>
                                <option value="1c">1º Ano C</option>
                                <option value="2a">2º Ano A</option>
                                <option value="2b">2º Ano B</option>
                                <option value="3a">3º Ano A</option>
                                <option value="3b">3º Ano B</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="atividade-data">Data de Aplicação</label>
                            <input type="date" id="atividade-data" required>
                        </div>
                        <div class="form-group">
                            <label for="atividade-prazo">Prazo de Entrega</label>
                            <input type="date" id="atividade-prazo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="atividade-descricao">Descrição</label>
                        <textarea id="atividade-descricao" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="atividade-valor">Valor (pontos)</label>
                        <input type="number" id="atividade-valor" min="1" max="10" step="0.1" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="cancel-btn">Cancelar</button>
                        <button type="submit" class="save-btn">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Registrar Frequência -->
    <div class="modal" id="frequencia-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Registrar Frequência</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="frequencia-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="frequencia-modal-turma">Turma</label>
                            <select id="frequencia-modal-turma" required>
                                <option value="">Selecione</option>
                                <option value="1c">1º Ano C</option>
                                <option value="2a">2º Ano A</option>
                                <option value="2b">2º Ano B</option>
                                <option value="3a">3º Ano A</option>
                                <option value="3b">3º Ano B</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="frequencia-modal-data">Data</label>
                            <input type="date" id="frequencia-modal-data" value="2025-04-03" required>
                        </div>
                    </div>
                    
                    <div class="frequencia-lista">
                        <h4>Lista de Alunos</h4>
                        <div class="frequencia-lista-container">
                            <div class="frequencia-item">
                                <div class="aluno-info">
                                    <span class="aluno-nome">Carlos Eduardo Silva</span>
                                    <span class="aluno-id">A015</span>
                                </div>
                                <div class="frequencia-opcoes">
                                    <label><input type="radio" name="freq-A015" value="presente" checked> Presente</label>
                                    <label><input type="radio" name="freq-A015" value="ausente"> Ausente</label>
                                    <label><input type="radio" name="freq-A015" value="atrasado"> Atrasado</label>
                                </div>
                                <div class="frequencia-obs">
                                    <input type="text" placeholder="Observação (opcional)">
                                </div>
                            </div>
                            
                            <div class="frequencia-item">
                                <div class="aluno-info">
                                    <span class="aluno-nome">Daniela Costa</span>
                                    <span class="aluno-id">A023</span>
                                </div>
                                <div class="frequencia-opcoes">
                                    <label><input type="radio" name="freq-A023" value="presente" checked> Presente</label>
                                    <label><input type="radio" name="freq-A023" value="ausente"> Ausente</label>
                                    <label><input type="radio" name="freq-A023" value="atrasado"> Atrasado</label>
                                </div>
                                <div class="frequencia-obs">
                                    <input type="text" placeholder="Observação (opcional)">
                                </div>
                            </div>
                            
                            <div class="frequencia-item">
                                <div class="aluno-info">
                                    <span class="aluno-nome">Enzo Fernandes</span>
                                    <span class="aluno-id">A024</span>
                                </div>
                                <div class="frequencia-opcoes">
                                    <label><input type="radio" name="freq-A024" value="presente" checked> Presente</label>
                                    <label><input type="radio" name="freq-A024" value="ausente"> Ausente</label>
                                    <label><input type="radio" name="freq-A024" value="atrasado"> Atrasado</label>
                                </div>
                                <div class="frequencia-obs">
                                    <input type="text" placeholder="Observação (opcional)">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="cancel-btn">Cancelar</button>
                        <button type="submit" class="save-btn">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>

