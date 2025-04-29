const select = document.getElementById("class-director");

fetch('api/get_teachers.php')
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      data.data.forEach(teacher => {
        const option = document.createElement("option");
        option.value = teacher.id;
        option.textContent = teacher.nome;
        select.appendChild(option);
      });
    } else {
      console.error("Erro ao carregar professores");
    }
  })
  .catch(err => console.error("Erro na requisição:", err));
