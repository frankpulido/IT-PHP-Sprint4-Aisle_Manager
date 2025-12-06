<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title ?? 'Sprint 4 - AisleManager'; ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="{{asset('styles/styles.css')}}" rel="stylesheet">
    <link href="{{asset('styles/section-layouts.css')}}" rel="stylesheet">
    
        <!-- Add the modal styles -->
        <style>
            /* Modal Styles */
            #productModal {
                display: none;  /* Hidden by default */
                position: fixed;
                z-index: 1;  /* Sit on top */
                left: 0;
                top: 0;
                width: 100%;  /* Full width */
                height: 100%;  /* Full height */
                overflow: auto;  /* Enable scrolling if needed */
                background-color: rgb(0, 0, 0);  /* Fallback color */
                background-color: rgba(0, 0, 0, 0.4);  /* Black w/ opacity */
                padding-top: 60px;
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            /* Close Button */
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
</head>