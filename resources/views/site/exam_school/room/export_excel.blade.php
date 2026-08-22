<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

</head>
<body>
@if ($contacts->count())
    <table>
        <tr>
            <th>Name</th>
            <th>Organization</th>
        </tr>
        @foreach ($contacts as $contact)

            <tr>
                <td>

                </td>
                <td>

                </td>
            </tr>

        @endforeach


    </table>
@endif
<style>
    td {
        height:30px;
        width:30px;
        wrap-text:true;
    }
</style>
</body>
</html>