document.addEventListener("DOMContentLoaded", () => {
    const guardianForm = document.getElementById("guardian-form");
    const guardianModal = document.getElementById("guardian-modal");
    const guardianSelect = document.getElementById("parents");
  
    guardianForm.addEventListener("submit", function (e) {
      e.preventDefault();
  
      const name = document.getElementById("guardian-name").value;
      const relation = document.getElementById("guardian-relation").value;
      const phone = document.getElementById("guardian-phone").value;
  
      fetch("api/guardians.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          action: "create",
          name,
          relation,
          phone,
        }),
      })
      .then(response => response.json())
      .then(result => {
          if (result.success && result.data && result.data.id) {
              const newOption = document.createElement('option');
              newOption.value = result.data.id;
              newOption.textContent = guardianName + (guardianRelation ? ` (${guardianRelation})` : '');
              newOption.selected = true;
      
              guardianSelect.appendChild(newOption);
              guardianForm.reset();
              document.getElementById('addGuardianModal').style.display = 'none';
          } else {
              alert('Erro ao cadastrar encarregado: ' + result.message);
          }
      })      
    });
    
  });
  
  