<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kamar Kost</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }

        .logout {
            text-align: right;
            margin-bottom: 20px;
        }

        .logout a {
            background-color: #ef4444;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .logout a:hover {
            background-color: #dc2626;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
            color: #374151;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
        }

        .available {
            background-color: #22c55e;
        }

        .unavailable {
            background-color: #ef4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logout">
            <a href="/logout">Logout</a>
        </div>

        <h2>Daftar Kamar Kost</h2>

        <table>
            <thead>
                <tr>
                    <th>Nomor Kamar</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                    <tr>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->type }}</td>
                        <td>Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $room->is_available ? 'available' : 'unavailable' }}">
                                {{ $room->is_available ? 'Tersedia' : 'Terisi' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
