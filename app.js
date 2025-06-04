document.addEventListener('DOMContentLoaded', function() {
    const studentForm = document.getElementById('studentForm');
    const studentList = document.getElementById('studentList');

    // Cargar estudiantes al iniciar
    loadStudents();

    // Manejar envío del formulario
    studentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const studentData = {
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            fecha_nacimiento: document.getElementById('fecha_nacimiento').value,
            dni: document.getElementById('dni').value,
            historial_medico: document.getElementById('historial_medico').value
        };

        fetch('save_student.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(studentData)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Estudiante guardado correctamente');
                studentForm.reset();
                loadStudents();
            } else {
                alert('Error al guardar: ' + data.message);
            }
        });
    });

    // Función para cargar estudiantes
    function loadStudents() {
        fetch('get_students.php')
            .then(response => response.json())
            .then(students => {
                studentList.innerHTML = '';
                students.forEach(student => {
                    const card = document.createElement('div');
                    card.className = 'student-card';
                    card.innerHTML = `
                        <h3>${student.nombre} ${student.apellido}</h3>
                        <p><strong>Fecha Nacimiento:</strong> ${student.fecha_nacimiento}</p>
                        <p><strong>DNI:</strong> ${student.dni}</p>
                        <p><strong>Historial Médico:</strong> ${student.historial_medico || 'N/A'}</p>
                    `;
                    studentList.appendChild(card);
                });
            });
    }
});