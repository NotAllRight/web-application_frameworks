<html>
<head>
    <title>Swagger UI</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.52.5/swagger-ui.css" />
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/3.52.5/swagger-ui-bundle.js"></script>
    <script>
        const ui = SwaggerUIBundle({
            url: "/swagger-docs",
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIBundle.presets.auth,
            ],
            layout: "BaseLayout",
        });
    </script>
</body>
</html>
