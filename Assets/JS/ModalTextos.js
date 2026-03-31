if (typeof FS_Textos === 'undefined') {
    window.FS_Textos = {};
}

FS_Textos.copyToClipboard = function(buttonElement) {
    const text = buttonElement.getAttribute('data-note');
    navigator.clipboard.writeText(text).then(function() {
        const originalIconHTML = buttonElement.innerHTML;
        const originalTitle = buttonElement.title;
        buttonElement.classList.remove('btn-light-grey');
        buttonElement.classList.add('btn-success');
        buttonElement.innerHTML = '<i class="fas fa-check"></i>';
        buttonElement.title = 'Copiado';

        setTimeout(() => {
            buttonElement.innerHTML = originalIconHTML;
            buttonElement.classList.remove('btn-success');
            buttonElement.classList.add('btn-light-grey');
            buttonElement.title = originalTitle;

        }, 3000);
    }, function(err) {
        console.error('No se pudo copiar el texto: ', err);
        alert("Error al copiar texto."); 
    });
};

FS_Textos.filterTextosTable = function() {
    var inputName, filterName, inputNote, filterNote, table, tr, tdName, tdNote, i, txtValueName, txtValueNote;
	
	inputName = document.getElementById("searchInputName");
	filterName = inputName.value.toUpperCase();
	inputNote = document.getElementById("searchInputNote");
	filterNote = inputNote.value.toUpperCase();
	table = document.getElementById("textosTable");
	var tbody = table.getElementsByTagName("tbody")[0];
	if (!tbody) return;
	tr = tbody.getElementsByTagName("tr"); 
	for (i = 0; i < tr.length; i++) {
		tdName = tr[i].getElementsByTagName("td")[0]; 
		tdNote = tr[i].getElementsByTagName("td")[1]; 
		if (tdName && tdNote) {
			txtValueName = tdName.textContent || tdName.innerText;
			txtValueNote = tdNote.textContent || tdNote.innerText;
			if (txtValueName.toUpperCase().indexOf(filterName) > -1 && txtValueNote.toUpperCase().indexOf(filterNote) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
};

// --- Manejo del Foco con jQuery ---
$(document).ready(function() {
    const modalElement = $('#modalTextGroups');

    if (modalElement.length) {
        // Usa el evento 'hide.bs.modal' de Bootstrap/jQuery
        modalElement.on('hide.bs.modal', function () {
            $('#searchInputName').blur();
            $('#searchInputNote').blur();
            $(this).find(':focus').blur();
        });

        $('#searchInputName, #searchInputNote').on('focusout', function() {
            // Cuando el usuario sale del input (p. ej., haciendo clic fuera del modal),
            // este evento se dispara y maneja el foco correctamente ANTES del cierre del modal.
        });
    }
});
