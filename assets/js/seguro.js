        // Datos de ejemplo (reemplazar con datos reales de la base de datos)
        const segurosData = [
            { id_seguro: 1, fk_id_camion: 101, empresa_aseguradora: "Seguros XYZ", vigencia: "2023-12-31", status_seguro: "Activo", tipo_pago: "Mensual", polizaAr: "POL-001", fecha_creacion: "2023-01-01" },
            { id_seguro: 2, fk_id_camion: 102, empresa_aseguradora: "Aseguradora ABC", vigencia: "2023-11-30", status_seguro: "Vencido", tipo_pago: "Anual", polizaAr: "POL-002", fecha_creacion: "2023-02-15" },
            // Agregar más datos de ejemplo aquí
        ];

        let currentPage = 1;
        const itemsPerPage = 10;
        let sortColumn = 'id_seguro';
        let sortOrder = 'ASC';

        const modalSeguro = document.getElementById('modalSeguro');
        const btnNuevoSeguro = document.getElementById('btnNuevoSeguro');
        const closeBtn = document.getElementsByClassName('close')[0];
        const formSeguro = document.getElementById('formSeguro');
        const searchInput = document.getElementById('searchInput');

        function renderTable(data) {
            const tableBody = document.getElementById('segurosTableBody');
            tableBody.innerHTML = '';

            data.forEach(seguro => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${seguro.fk_id_camion}</td>
                    <td>${seguro.empresa_aseguradora}</td>
                    <td>${seguro.vigencia}</td>
                    <td><span class="status-badge ${seguro.status_seguro.toLowerCase().replace(' ', '-')}">${seguro.status_seguro}</span></td>
                    <td>${seguro.tipo_pago}</td>
                    <td>${seguro.polizaAr || 'N/A'}</td>
                    <td>${seguro.fecha_creacion}</td>
                    <td>
                        <button class="action-btn edit-btn" data-id="${seguro.id_seguro}">✏️</button>
                        <button class="action-btn delete-btn" data-id="${seguro.id_seguro}">🗑️</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            setupEditButtons();
            setupDeleteButtons();
        }

        function setupPagination(filteredData) {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            const paginationControls = document.getElementById('paginationControls');
            const paginationInfo = document.getElementById('paginationInfo');

            paginationControls.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.innerText = i;
                btn.classList.add('btn', i === currentPage ? 'btn-primary' : 'btn-secondary');
                btn.addEventListener('click', () => {
                    currentPage = i;
                    renderTableWithPagination(filteredData);
                });
                paginationControls.appendChild(btn);
            }

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredData.length);
            paginationInfo.innerText = `Mostrando ${startIndex + 1} a ${endIndex} de ${filteredData.length} registros`;
        }

        function renderTableWithPagination(data) {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const paginatedData = data.slice(startIndex, startIndex + itemsPerPage);
            renderTable(paginatedData);
            setupPagination(data);
        }

        function sortData(data, column, order) {
            return data.sort((a, b) => {
                if (a[column] < b[column]) return order === 'ASC' ? -1 : 1;
                if (a[column] > b[column]) return order === 'ASC' ? 1 : -1;
                return 0;
            });
        }

        function setupSorting() {
            const headers = document.querySelectorAll('th[data-sort]');
            headers.forEach(header => {
                header.addEventListener('click', () => {
                    const column = header.dataset.sort;
                    if (sortColumn === column) {
                        sortOrder = sortOrder === 'ASC' ? 'DESC' : 'ASC';
                    } else {
                        sortColumn = column;
                        sortOrder = 'ASC';
                    }
                    const sortedData = sortData(filterData(segurosData), sortColumn, sortOrder);
                    renderTableWithPagination(sortedData);
                });
            });
        }

        function filterData(data) {
            const searchTerm = searchInput.value.toLowerCase();
            return data.filter(seguro => 
                seguro.empresa_aseguradora.toLowerCase().includes(searchTerm) ||
                seguro.polizaAr.toLowerCase().includes(searchTerm)
            );
        }

        function setupSearch() {
            searchInput.addEventListener('input', () => {
                currentPage = 1;
                const filteredData = filterData(segurosData);
                renderTableWithPagination(filteredData);
            });
        }

        function setupEditButtons() {
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const seguroId = button.getAttribute('data-id');
                    const seguro = segurosData.find(s => s.id_seguro == seguroId);
                    if (seguro) {
                        document.getElementById('modalTitle').innerText = 'Editar Seguro';
                        document.getElementById('seguroId').value = seguro.id_seguro;
                        document.getElementById('fk_id_camion').value = seguro.fk_id_camion;
                        document.getElementById('empresa_aseguradora').value = seguro.empresa_aseguradora;
                        document.getElementById('vigencia').value = seguro.vigencia;
                        document.getElementById('status_seguro').value = seguro.status_seguro;
                        document.getElementById('tipo_pago').value = seguro.tipo_pago;
                        document.getElementById('polizaAr').value = seguro.polizaAr || '';
                        modalSeguro.style.display = 'block';
                    }
                });
            });
        }

        function setupDeleteButtons() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const seguroId = button.getAttribute('data-id');
                    if (confirm('¿Está seguro de que desea eliminar este seguro?')) {
                        // Aquí iría la lógica para eliminar el seguro de la base de datos
                        segurosData = segurosData.filter(s => s.id_seguro != seguroId);
                        renderTableWithPagination(filterData(segurosData));
                    }
                });
            });
        }

        btnNuevoSeguro.onclick = function() {
            document.getElementById('modalTitle').innerText = 'Agregar Nuevo Seguro';
            formSeguro.reset();
            document.getElementById('seguroId').value = '';
            modalSeguro.style.display = 'block';
        }

        closeBtn.onclick = function() {
            modalSeguro.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modalSeguro) {
                modalSeguro.style.display = 'none';
            }
        }

        formSeguro.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(formSeguro);
            const seguroData = Object.fromEntries(formData.entries());
            
            if (seguroData.id_seguro) {
                // Actualizar seguro existente
                const index = segurosData.findIndex(s => s.id_seguro == seguroData.id_seguro);
                if (index !== -1) {
                    segurosData[index] = { ...segurosData[index], ...seguroData };
                }
            } else {
                // Agregar nuevo seguro
                seguroData.id_seguro = segurosData.length + 1;
                seguroData.fecha_creacion = new Date().toISOString().split('T')[0];
                segurosData.push(seguroData);
            }

            renderTableWithPagination(filterData(segurosData));
            modalSeguro.style.display = 'none';
        }

        // Inicialización
        renderTableWithPagination(segurosData);
        setupSorting();
        setupSearch();