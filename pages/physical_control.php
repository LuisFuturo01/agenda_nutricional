<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrintel - Control Físico</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/index.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 50%, #ecfdf5 100%);
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
        }

        

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .page-header p {
            font-size: 16px;
            color: #6b7280;
            font-weight: 400;
        }

        /* Table Container */
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(90, 243, 192, 0.2);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f3f4f6;
        }

        .table-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-title::before {
            content: '📊';
            font-size: 28px;
        }

        .add-record-btn {
            background: linear-gradient(135deg, #5af3c0 0%, #22c55e 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(90, 243, 192, 0.3);
        }

        .add-record-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(90, 243, 192, 0.4);
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .data-table thead {
            background: linear-gradient(135deg, #5af3c0 0%, #22c55e 100%);
        }

        .data-table thead th {
            padding: 20px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .data-table tbody tr {
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .data-table tbody tr:hover {
            background: rgba(90, 243, 192, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .data-table tbody td {
            padding: 18px 16px;
            font-size: 15px;
            font-weight: 400;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Measurement Values */
        .measurement-value {
            font-weight: 600;
            color: #1f2937;
        }

        .measurement-unit {
            font-size: 13px;
            color: #6b7280;
            font-weight: 400;
            margin-left: 4px;
        }

        /* Date Column */
        .date-cell {
            color: #22c55e;
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 24px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-header {
                flex-direction: column;
                gap: 16px;
                padding: 16px 20px;
            }

            .header-left .page-title {
                font-size: 20px;
                text-align: center;
            }

            .nav-links {
                gap: 16px;
            }

            .nav-links li a {
                padding: 6px 12px;
                font-size: 14px;
            }

            .main-content {
                padding: 24px 16px;
            }

            .page-header h2 {
                font-size: 24px;
            }

            .table-container {
                padding: 20px;
                border-radius: 16px;
            }

            .table-header {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .table-title {
                justify-content: center;
                font-size: 20px;
            }

            /* Mobile Table Scroll */
            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .data-table {
                min-width: 600px;
            }

            .data-table thead th,
            .data-table tbody td {
                padding: 12px 8px;
                font-size: 13px;
            }

            .data-table thead th {
                white-space: nowrap;
            }
        }

        @media (max-width: 480px) {
            .nav-links {
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }

            .nav-links li {
                width: 100%;
            }

            .nav-links li a {
                display: block;
                text-align: center;
                width: 100%;
            }

            .page-header h2 {
                font-size: 20px;
            }

            .table-container {
                padding: 16px;
            }

            .data-table {
                min-width: 500px;
            }
        }

        /* Focus styles for accessibility */
        .nav-links li a:focus-visible,
        .add-record-btn:focus-visible {
            outline: 2px solid #5af3c0;
            outline-offset: 2px;
        }

        /* Loading animation for future use */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .loading {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body>
    <?php $nombre_usuario_simulado = "María González"; ?>
    
    <header class="main-header">
        <div class="header-left">
            <h1 class="page-title">Nutrintel - Agenda de <?php echo htmlspecialchars($nombre_usuario_simulado); ?></h1>
        </div>
        <div class="header-right">
            <nav>
                <ul class="nav-links">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="#">Perfil</a></li>
                    <li><a href="#" id="logout">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="page-header">
            <h2>Control Físico</h2>
            <p>Seguimiento de tus medidas corporales y progreso</p>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3 class="table-title">Historial de Medidas</h3>
                <button class="add-record-btn">+ Agregar Registro</button>
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Peso</th>
                            <th>Cintura</th>
                            <th>Pecho</th>
                            <th>Bíceps</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="measurement-value">68.5</span>
                                <span class="measurement-unit">kg</span>
                            </td>
                            <td>
                                <span class="measurement-value">82</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">95</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">32</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td class="date-cell">15/01/2024</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="measurement-value">69.2</span>
                                <span class="measurement-unit">kg</span>
                            </td>
                            <td>
                                <span class="measurement-value">81</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">96</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">32.5</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td class="date-cell">08/01/2024</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="measurement-value">70.1</span>
                                <span class="measurement-unit">kg</span>
                            </td>
                            <td>
                                <span class="measurement-value">83</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">94</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">31.8</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td class="date-cell">01/01/2024</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="measurement-value">71.3</span>
                                <span class="measurement-unit">kg</span>
                            </td>
                            <td>
                                <span class="measurement-value">84</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">93</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">31.2</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td class="date-cell">25/12/2023</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="measurement-value">72.0</span>
                                <span class="measurement-unit">kg</span>
                            </td>
                            <td>
                                <span class="measurement-value">85</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">92</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td>
                                <span class="measurement-value">30.8</span>
                                <span class="measurement-unit">cm</span>
                            </td>
                            <td class="date-cell">18/12/2023</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>