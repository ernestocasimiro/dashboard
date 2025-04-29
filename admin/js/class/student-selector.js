const alunoContainer = document.getElementById("available-students");
const selectedAlunos = [];

function atualizarContador() {
  document.getElementById("selected-students-count").textContent = selectedAlunos.length;
}

document.getElementById("add-students-btn").addEventListener("click", () => {
  fetch('api/get_students.php')
    .then(res => res.json())
    .then(data => {
      alunoContainer.innerHTML = '';

      if (data.success && data.data.length > 0) {
        data.data.forEach(aluno => {
          const div = document.createElement("div");
          div.className = "student-card";
          div.textContent = aluno.nome;
          div.dataset.id = aluno.id;

          div.addEventListener("click", () => {
            div.classList.toggle("selected");
            const id = aluno.id;

            if (selectedAlunos.includes(id)) {
              selectedAlunos.splice(selectedAlunos.indexOf(id), 1);
            } else {
              if (selectedAlunos.length < 25) {
                selectedAlunos.push(id);
              } else {
                alert("Capacidade máxima atingida");
              }
            }

            atualizarContador();
          });

          alunoContainer.appendChild(div);
        });
      } else {
        alunoContainer.innerHTML = "<p class='empty-message'>Nenhum aluno disponível</p>";
      }
    });
});

document.getElementById("confirm-students").addEventListener("click", () => {
  const selectionContainer = document.getElementById("student-selection-container");
  selectionContainer.innerHTML = '';

  selectedAlunos.forEach(id => {
    const item = document.createElement("p");
    item.textContent = `Aluno ID: ${id}`;
    selectionContainer.appendChild(item);
  });

  atualizarContador();
  document.getElementById("students-modal").style.display = "none";
});
