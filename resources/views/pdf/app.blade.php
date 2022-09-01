<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <title>{{ $title }}</title>
    <style>
    .custom-table {
        font-size: 14px !important;

    }

    .custom-table td {
        font-size: 12px !important;
        padding: 5px;

    }

    .custom-header-table {
        background-color: rgb(85, 88, 139);
        color: #fff;
        margin-bottom: 10px;

    }

    .custom-header-table th {
        padding: 10px !important;

    }

    .customer-table-boody {
        border-bottom: 1px #ccc solid;

    }

    .custom-table-footer {
        margin-top: 20px !important;
    }

    .border-radius-first {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .border-radius-last {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    </style>
    <title>{{ $title }}</title>
</head>

<body>
    <h4>{{ $title }}</h4>
    <table width="100%">
        <tr>
            <td width="60%">
                <img src="https://png.pngtree.com/element_pic/00/16/09/2057e0eecf792fb.jpg" width="100px"
                    height="100px">
            </td>
            <td>
                <h4>{{ config('company.company_name') }}</h4>
                <address>
                    <p>{{ config('company.address') }} <br>
                    {{ config('company.email') }} <br>
                    {{ config('company.phone') }}</p>
                </address>
            </td>
        </tr>
    </table>

    @yield('content')

</body>

</html>