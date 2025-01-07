<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular Promedio / To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="text-center">
            <h1>Calcular Promedio</h1>
            <form id="form-promedio" class="mb-4">
                <div class="mb-3">
                    <label for="numeros" class="form-label">Ingrese números separados por comas:</label>
                    <input type="text" id="numeros" class="form-control" placeholder="Ej: 1,2,3,4,5">
                </div>
                <button type="submit" class="btn btn-primary">Calcular </button>
            </form>
            <h3 id="result" class="mt-3" style="color: rgb(255, 0, 0);"></h3>
        </div>
    </div>

    <div class="container mt-5">
        <div class="text-center">
            <x-task-list-component :tasks="$tasks" />
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            let arrayNumeros = [];

            $('#form-promedio').on('submit', function (e) {
                e.preventDefault();
                const numerosInput = $('#numeros').val();
                if (!numerosInput.trim()) {
                    $('#result').text("Error: Ingresa al menos un número.");
                    return;
                }
                const numeros = numerosInput.split(',').map(num => parseFloat(num.trim()));

                if (numeros.some(isNaN)) {
                    $('#result').text("Error: Ingresa solo números válidos separados por comas.");
                    return;
                }

                arrayNumeros = [...numeros];

                const promedio = calcularPromedio(numeros);

                $('#result').text(`El promedio es: ${promedio}`);
            });
        });

        function calcularPromedio(numeros) {
            if (numeros.length === 0) {
                return "Error: el array está vacío.";
            }

            const suma = numeros.reduce((acc, num) => acc + num, 0);
            return (suma / numeros.length).toFixed(2);
        }
    </script>
</body>
</html>
