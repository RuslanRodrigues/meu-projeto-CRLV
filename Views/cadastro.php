<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Britacal - Pesquisa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">

    <!-- <link rel="stylesheet" href="../style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">

</head>

<body>
    <main id="L" class="container mt-5">
        <table id="allVehiclesTable" class="table datatable">
            <thead>
                <tr>
                    <th scope="col">Placa</th>
                    <th scope="col">Exercício</th>
                    <th scope="col">Marca/Modelo</th>
                    <th scope="col">CRLV</th>
                </tr>
            </thead>
            <tbody id="allVehiclesBody">
                <!-- Os dados serão carregados via JavaScript -->
            </tbody>
        </table>
    </main>
    <br>
    <script>
        // Função para carregar os veículos
        function loadAllVehicles() {
            fetch('allVehicles.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('allVehiclesBody');
                    data.forEach((vehicle, index) => {
                        const tr = document.createElement('tr');
                        const downloadButtonId = `downloadButton${index}`; // ID único para cada botão de download
                        tr.innerHTML = `
                            <td>${vehicle.placa}</td>
                            <td>${vehicle.exercicio}</td>
                            <td>${vehicle.marca}</td>
                            <td>
                                <a id="${downloadButtonId}" href="${vehicle.arquivo_img}" class="btn btn-success" download>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.6A1.5 1.5 0 0 0 2.5 14.5h11A1.5 1.5 0 0 0 15 13v-2.6a.5.5 0 0 1 1 0v2.6A2.5 2.5 0 0 1 13.5 15.5h-11A2.5 2.5 0 0 1 0 13v-2.6a.5.5 0 0 1 .5-.5zm4-2.4a.5.5 0 0 1 .5.5v4.9l2.5-2.5a.5.5 0 0 1 .7 0l2.5 2.5V7.4a.5.5 0 0 1 1 0v5a.5.5 0 0 1-.8.4L8 10.7 5.3 12.8a.5.5 0 0 1-.8-.4v-5a.5.5 0 0 1 .5-.5z" />
                                    </svg>
                                    Download
                                </a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });

                    // Inicializar o DataTables após os dados serem carregados
                    $('#allVehiclesTable').DataTable({
                        "pageLength": 10,
                        "pagingType": "full_numbers",
                        "language": {
                            "sEmptyTable": "Nenhum registro encontrado",
                            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sInfoThousands": ".",
                            "sLengthMenu": "_MENU_ resultados por página",
                            "sLoadingRecords": "Carregando...",
                            "sProcessing": "Processando...",
                            "sZeroRecords": "Nenhum registro encontrado",
                            "sSearch": "Pesquisar",
                            "oPaginate": {
                                "sNext": "Próximo",
                                "sPrevious": "Anterior",
                                "sFirst": "Primeiro",
                                "sLast": "Último"
                            },
                            "oAria": {
                                "sSortAscending": ": Ordenar colunas de forma ascendente",
                                "sSortDescending": ": Ordenar colunas de forma descendente"
                            }
                        }
                    });
                })
                .catch(error => console.error('Erro ao carregar veículos:', error));
        }

        // Carrega todos os veículos ao carregar a página
        document.addEventListener('DOMContentLoaded', loadAllVehicles);
    </script>
       <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

</body>

</html>
