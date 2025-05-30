<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <header class="bg-white shadow-md p-4 flex justify-between items-center container mx-auto mt-6 rounded-lg">
        <a href="" home class="text-2xl font-bold text-gray-800">Home</a>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="" class="text-gray-600 hover:text-gray-800">Users (change to only admin)</a></li>
                <li><a href="route('profile.edit')" class="text-gray-600 hover:text-gray-800">Profile</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-gray-600 hover:text-gray-800">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    @yield('content')

</body>

</html>