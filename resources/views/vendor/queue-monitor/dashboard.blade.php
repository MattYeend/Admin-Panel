<!DOCTYPE html>
<html>
    <head>
        <title>Queue Monitor</title>
    </head>
    <body>
        <h1>Queue Monitoring Dashboard</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Queue<th>
                    <th>Jobs Processed<th>
                    <th>Failed Jobs<th>
                    <th>Average Time (ms)<th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats as $stat)
                    <tr>
                        <td>{{ $stat->queue }}</td>
                        <td>{{ $stat->processed }}</td>
                        <td>{{ $stat->failed }}</td>
                        <td>{{ $stat->average_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>