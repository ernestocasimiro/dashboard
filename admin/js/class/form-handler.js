import { selectedAlunos } from './student-selector.js';

export function inicializarFormulario() {
    document.getElementById('class-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const turmaData = {
            nome: document.getElementById("class-name").value,
            ano: document.getElementById("class-grade").value,
            capacidade: document.getElementById("class-capacity").value,
            diretor_id: document.getElementById("class-director").value,
            turno: document.getElementById("class-schedule").value,
            descricao: document.getElementById("class-description").value,
            alunos: selectedAlunos
        };

        fetch('api/save_class.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(turmaData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // atualizar lista ou fechar modal
            } else {
                alert("Erro: " + data.message);
            }
        })
        .catch(err => console.error("Erro na requisição:", err));
    });
}
