<?php
if (!isset($page_title)) $page_title = 'CRUD Game Konsol';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <style>
    :root {
        --grass: #8bc34a;
        --dirt: #a1887f;
        --stone: #9e9e9e;
        --water: #4fc3f7;
        --wood: #8d6e63;
        --cloud: #f5f5f5;
        --sky: #bbdefb;
        --lava: #ff9800;
        --diamond: #4dd0e1;
        --emerald: #66bb6a;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 1000px;
        margin: 20px auto;
        padding: 0 15px;
        color: #333;
        background: linear-gradient(135deg, var(--sky) 0%, #e3f2fd 100%);
        min-height: 100vh;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 15px 20px;
        background: var(--grass);
        border: 4px solid #689f38;
        border-radius: 8px;
        box-shadow: 0 4px 0 #558b2f;
        position: relative;
    }

    header::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 4px;
        right: 4px;
        height: 4px;
        background: var(--dirt);
        border-radius: 2px;
    }

    h1 {
        color: white;
        text-shadow: 2px 2px 0 #558b2f;
        margin: 0;
        font-size: 1.8rem;
    }

    a {
        color: var(--water);
        text-decoration: none;
        font-weight: 500;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background: white;
        border: 3px solid var(--stone);
        border-radius: 6px;
        overflow: hidden;
    }

    th, td {
        border: 2px solid var(--stone);
        padding: 12px;
        text-align: left;
    }

    th {
        background: var(--stone);
        color: white;
        text-shadow: 1px 1px 0 #757575;
    }

    tr:nth-child(even) {
        background: #f5f5f5;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        border: 2px solid;
        font-weight: bold;
        text-shadow: 1px 1px 0 rgba(0,0,0,0.1);
        transition: all 0.2s;
        text-align: center;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .btn-primary {
        background: var(--water);
        color: white;
        border-color: #0288d1;
    }

    .btn-danger {
        background: var(--lava);
        color: white;
        border-color: #ef6c00;
    }

    .form-row {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .form-row input[type=text], 
    .form-row input[type=number], 
    .form-row input[type=search],
    textarea {
        padding: 10px;
        border: 2px solid var(--stone);
        border-radius: 4px;
        background: white;
        font-size: 1rem;
    }

    .form-row input:focus {
        outline: none;
        border-color: var(--water);
        box-shadow: 0 0 0 2px rgba(79, 195, 247, 0.3);
    }

    .message {
        padding: 15px;
        background: var(--emerald);
        border: 3px solid #4caf50;
        border-radius: 6px;
        margin: 15px 0;
        color: white;
        text-shadow: 1px 1px 0 #388e3c;
    }

    .error {
        background: var(--lava);
        border-color: #f44336;
        text-shadow: 1px 1px 0 #d32f2f;
    }

    .small {
        font-size: 0.9rem;
        color: #666;
    }
    
    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    main {
        background: white;
        padding: 25px;
        border: 4px solid var(--wood);
        border-radius: 8px;
        box-shadow: 0 6px 0 #6d4c41;
        margin-bottom: 20px;
    }

    /* Minecraft block pattern for footer */
    .minecraft-block {
        background: 
            linear-gradient(45deg, transparent 48%, var(--dirt) 48%, var(--dirt) 52%, transparent 52%),
            linear-gradient(-45deg, transparent 48%, var(--dirt) 48%, var(--dirt) 52%, transparent 52%);
        background-size: 20px 20px;
        background-color: #a1887f;
    }

    /* Pixel art style for buttons */
    .btn {
        image-rendering: pixelated;
        image-rendering: -moz-crisp-edges;
        image-rendering: crisp-edges;
    }

    /* Minecraft-style pagination */
    .pagination {
        display: flex;
        gap: 5px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .form-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .actions {
            justify-content: center;
        }
        
        table {
            font-size: 0.9rem;
        }
    }
    </style>
</head>
<body>
<header>
    <h1>⛏️ <?php echo htmlspecialchars($page_title); ?></h1>
    <nav>
        <a class="btn" href="read.php" style="background: var(--cloud); color: #333; border-color: #bdbdbd;">📋 Daftar</a>
        <a class="btn btn-primary" href="create.php">✨ Tambah Produk</a>
    </nav>
</header>
<main>