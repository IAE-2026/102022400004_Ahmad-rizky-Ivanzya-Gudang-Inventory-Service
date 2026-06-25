<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GraphQL Playground - Inventory Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/graphql-playground-react/build/static/css/index.css" />
    <script src="https://cdn.jsdelivr.net/npm/graphql-playground-react/build/static/js/middleware.js"></script>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        #root {
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="root"></div>
    <script>
        window.addEventListener('load', function () {
            GraphQLPlayground.init(document.getElementById('root'), {
                endpoint: '{{ $graphqlEndpoint }}',
                headers: {
                    'X-IAE-KEY': '{{ env('API_KEY', '102022400004') }}'
                }
            });
        });
    </script>
</body>
</html>
