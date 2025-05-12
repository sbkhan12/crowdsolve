<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrowdSolve | Empowering Communities</title>
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">CrowdSolve</h1>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Get Started</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-100 py-16">
        <div class="max-w-5xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold mb-4 text-blue-900">Empowering Communities to Solve Real Problems</h2>
            <p class="text-lg text-blue-800 mb-6">
                CrowdSolve connects citizens, experts, and authorities to collaboratively identify, vote on, and solve local issues — from potholes to pollution.
            </p>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700">
                Report an Issue Now
            </a>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-3xl font-semibold text-center mb-10">How It Works</h3>
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-5xl text-blue-500 mb-3">📝</div>
                    <h4 class="font-bold text-lg">Report a Problem</h4>
                    <p class="text-sm mt-2">Citizens submit local issues with descriptions, locations, and media.</p>
                </div>
                <div>
                    <div class="text-5xl text-green-500 mb-3">👍</div>
                    <h4 class="font-bold text-lg">Vote & Discuss</h4>
                    <p class="text-sm mt-2">Community members upvote, comment, and suggest solutions collaboratively.</p>
                </div>
                <div>
                    <div class="text-5xl text-yellow-500 mb-3">🏛</div>
                    <h4 class="font-bold text-lg">Get It Solved</h4>
                    <p class="text-sm mt-2">Authorities assign and update progress, with experts guiding implementation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-3xl font-semibold text-center mb-10">Platform Features</h3>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded shadow">
                    <h4 class="font-bold text-lg mb-2">Problem Reporting with Media</h4>
                    <p class="text-sm">Citizens can submit detailed reports including images, videos, and location tags.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h4 class="font-bold text-lg mb-2">Voting & Prioritization</h4>
                    <p class="text-sm">Issues are ranked based on community votes, ensuring visibility for urgent matters.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h4 class="font-bold text-lg mb-2">Expert Insights</h4>
                    <p class="text-sm">Verified experts can contribute ideas, advice, and highlight feasible solutions.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h4 class="font-bold text-lg mb-2">Authority Engagement</h4>
                    <p class="text-sm">Authorities can assign themselves, post progress, and mark issues as resolved.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-blue-600 py-16 text-white text-center">
        <h3 class="text-3xl font-bold mb-4">Be Part of the Change</h3>
        <p class="mb-6">Join CrowdSolve and help build better, safer, and smarter communities.</p>
        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded shadow hover:bg-gray-200">
            Sign Up for Free
        </a>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-6 mt-12 border-t">
        <div class="max-w-6xl mx-auto px-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} CrowdSolve. All rights reserved.
        </div>
    </footer>
</body>
</html>
