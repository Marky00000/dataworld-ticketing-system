<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center">
              <div class="h-8 w-8 bg-blue-600 rounded-md flex items-center justify-center">
                <span class="text-white font-bold">T</span>
              </div>
              <span class="ml-2 text-xl font-bold text-gray-900">TicketFlow</span>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <Link
              v-if="canLogin"
              :href="route('login')"
              class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium"
            >
              Login
            </Link>
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Register
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
      <div class="text-center">
        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
          <span class="block">Modern Ticketing</span>
          <span class="block text-blue-600">Made Simple</span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
          Streamline customer support, manage tickets efficiently, and deliver exceptional service with our intuitive ticketing system.
        </p>
        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
          <div class="rounded-md shadow">
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10"
            >
              Get Started Free
            </Link>
          </div>
          <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
            <a href="#features" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
              Learn More
            </a>
          </div>
        </div>
      </div>
    </main>

    <!-- Temporary placeholder for the rest -->
    <div class="py-20 text-center text-gray-500">
      <p>Next steps will add features section, testimonials, and footer</p>
      <p class="mt-2 text-sm">Let's continue to Step 2!</p>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<style scoped>
/* We'll add proper styling in next steps */
</style>