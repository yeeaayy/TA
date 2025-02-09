<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create EMQX Rule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Create EMQX Rule</h2>
        <form action="{{ url('/rules') }}" method="POST" id="ruleForm">
            @csrf
            <div class="mb-3">
                <label for="rule_name" class="form-label">Rule Name</label>
                <input type="text" class="form-control" id="rule_name" name="rule_name" placeholder="Enter Rule Name" required>
            </div>
            <div class="mb-3">
                <label for="rawsql" class="form-label">SQL Query</label>
                <textarea class="form-control" id="rawsql" name="rawsql" rows="4" placeholder="Example: SELECT temperature FROM \"t/sensor\" WHERE temperature > 25" required></textarea>
            </div>
            <div id="actionsContainer">
                <div class="action mb-4">
                    <h5>Action #1</h5>
                    <div class="mb-3">
                        <label for="action_name_1" class="form-label">Action Name</label>
                        <input type="text" class="form-control" id="action_name_1" name="actions[0][name]" placeholder="Enter Action Name (e.g., data_to_webserver)" required>
                    </div>
                    <div class="mb-3">
                        <label for="action_url_1" class="form-label">Action URL</label>
                        <input type="url" class="form-control" id="action_url_1" name="actions[0][params][url]" placeholder="Enter Action URL (e.g., http://example.com/api)" required>
                    </div>
                    <div class="mb-3">
                        <label for="action_body_1" class="form-label">Action Body</label>
                        <textarea class="form-control" id="action_body_1" name="actions[0][params][body]" rows="4" placeholder="Example: {\"temperature\": ${temperature}, \"humidity\": ${humidity}}" required></textarea>
                    </div>
                </div>
            </div>
            <button type="button" id="addAction" class="btn btn-secondary mb-3">Add Action</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        let actionCount = 1;

        document.getElementById('addAction').addEventListener('click', function () {
            actionCount++;
            const container = document.getElementById('actionsContainer');
            const actionHtml = `
                <div class="action mb-4">
                    <h5>Action #${actionCount}</h5>
                    <div class="mb-3">
                        <label for="action_name_${actionCount}" class="form-label">Action Name</label>
                        <input type="text" class="form-control" id="action_name_${actionCount}" name="actions[${actionCount - 1}][name]" placeholder="Enter Action Name (e.g., data_to_webserver)" required>
                    </div>
                    <div class="mb-3">
                        <label for="action_url_${actionCount}" class="form-label">Action URL</label>
                        <input type="url" class="form-control" id="action_url_${actionCount}" name="actions[${actionCount - 1}][params][url]" placeholder="Enter Action URL (e.g., http://example.com/api)" required>
                    </div>
                    <div class="mb-3">
                        <label for="action_body_${actionCount}" class="form-label">Action Body</label>
                        <textarea class="form-control" id="action_body_${actionCount}" name="actions[${actionCount - 1}][params][body]" rows="4" placeholder="Example: {\"temperature\": ${temperature}, \"humidity\": ${humidity}}" required></textarea>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', actionHtml);
        });
    </script>
</body>
</html>
