<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CrowdSolve | Empowering Communities</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-200 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">CrowdSolve</h1>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Get Started</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-100 py-20">
        <div class="max-w-5xl mx-auto text-center px-6">
            <h2 class="text-5xl font-extrabold text-blue-900 mb-4">Empowering Communities to Solve Real Problems</h2>
            <p class="text-lg text-blue-800 mb-6 max-w-3xl mx-auto">
                CrowdSolve connects citizens, experts, and authorities to collaboratively identify, vote on, and solve local issues — from potholes to pollution.
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                Report an Issue Now
            </a>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-4xl font-bold text-center text-gray-800 mb-12">How It Works</h3>
            <div class="grid md:grid-cols-3 gap-10 text-center">
                <div>
                    <div class="text-5xl text-blue-500 mb-4">📝</div>
                    <h4 class="text-xl font-semibold mb-2">Report a Problem</h4>
                    <p class="text-gray-600 text-sm">Citizens submit local issues with location, description, and images.</p>
                </div>
                <div>
                    <div class="text-5xl text-green-500 mb-4">👍</div>
                    <h4 class="text-xl font-semibold mb-2">Vote & Discuss</h4>
                    <p class="text-gray-600 text-sm">Communities upvote, comment, and suggest practical solutions.</p>
                </div>
                <div>
                    <div class="text-5xl text-yellow-500 mb-4">🏛</div>
                    <h4 class="text-xl font-semibold mb-2">Get It Solved</h4>
                    <p class="text-gray-600 text-sm">Authorities take action and update progress transparently.</p>
                </div>
            </div>
        </div>
    </section>
<!-- Live Stats -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-4xl font-bold text-center mb-12 text-gray-800">Our Impact in Numbers</h3>
        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="bg-blue-50 rounded-lg p-6 shadow hover:shadow-md transition">
                <h4 class="text-5xl font-extrabold text-blue-600">{{ number_format($totalProblems) }}</h4>
                <p class="text-sm mt-2 text-gray-600">Issues Reported</p>
            </div>
            <div class="bg-green-50 rounded-lg p-6 shadow hover:shadow-md transition">
                <h4 class="text-5xl font-extrabold text-green-600">{{ number_format($solvedProblems) }}</h4>
                <p class="text-sm mt-2 text-gray-600">Problems Solved</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-6 shadow hover:shadow-md transition">
                <h4 class="text-5xl font-extrabold text-yellow-600">{{ number_format($activeUsers) }}</h4>
                <p class="text-sm mt-2 text-gray-600">Active Community Members</p>
            </div>
        </div>
    </div>
</section>

    <!-- Features -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-4xl font-bold text-center mb-12 text-gray-800">Platform Features</h3>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold mb-2">📸 Problem Reporting with Media</h4>
                    <p class="text-gray-600 text-sm">Upload images, videos, and geotags to enrich issue reports.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold mb-2">📊 Voting & Prioritization</h4>
                    <p class="text-gray-600 text-sm">Vote to prioritize what matters most to the local community.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold mb-2">🎓 Expert Insights</h4>
                    <p class="text-gray-600 text-sm">Experts add credibility and suggest feasible solutions.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold mb-2">🏢 Authority Engagement</h4>
                    <p class="text-gray-600 text-sm">Local officials track, assign, and resolve problems transparently.</p>
                </div>
            </div>
        </div>
    </section>


<!-- Testimonials / News -->
<section class="py-20 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-4xl font-bold text-center text-gray-800 mb-12">Voices from the Community</h3>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <p class="italic text-gray-700 mb-4">“Thanks to CrowdSolve, our neighborhood finally fixed the overflowing trash problem that had been ignored for months!”</p>
                <div class="flex items-center space-x-4">
                    <img src="https://i.pravatar.cc/40?img=3" alt="User" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Fatima Ali</p>
                        <p class="text-xs text-gray-500">Resident, Karachi</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <p class="italic text-gray-700 mb-4">“As a city official, CrowdSolve helps me prioritize real issues backed by community votes. It’s a game changer.”</p>
                <div class="flex items-center space-x-4">
                    <img src="https://i.pravatar.cc/40?img=5" alt="User" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Engr. Khalid Mehmood</p>
                        <p class="text-xs text-gray-500">Municipal Officer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Call to Action -->
    <section class="bg-blue-700 py-20 text-white text-center">
        <h3 class="text-4xl font-bold mb-4">Be Part of the Change</h3>
        <p class="mb-6 text-lg">Join CrowdSolve to help build smarter, more responsive communities.</p>
        <a href="{{ route('register') }}" class="bg-white text-blue-700 px-8 py-3 text-lg rounded shadow hover:bg-gray-200 transition">
            Sign Up for Free
        </a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-200 py-6 border-t mt-16">
        <div class="max-w-6xl mx-auto px-6 text-center text-sm text-dark-500">
            &copy; {{ date('Y') }} CrowdSolve. All rights reserved.
        </div>
    </footer>

</body>
</html>
