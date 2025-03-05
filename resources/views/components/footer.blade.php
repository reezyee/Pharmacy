<footer class="bg-white">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <!-- Logo and Map section -->
        <div class="flex flex-col md:flex-row justify-between gap-8">
            <div class="mb-6 md:mb-0 flex flex-col items-center md:items-start">
                <a href="" class="flex flex-col items-center md:items-start gap-4">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/images/logo.png') }}" class="h-8 me-3" alt="Logo" />
                        <span class="self-center text-2xl font-semibold whitespace-nowrap">Apotek Amanah</span>
                    </div>
                </a>
            </div>

            <!-- Footer Links Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 w-full md:w-auto">
                <!-- About Us -->
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">About Us</h2>
                    <ul class="text-gray-500 font-medium flex flex-col gap-2">
                        <li>
                            <a href="/contact" class="hover:underline">About Us</a>
                        </li>
                        <li>
                            <a href="/contact" class="hover:underline">Contact Us</a>
                        </li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Legal</h2>
                    <ul class="text-gray-500 font-medium flex flex-col gap-2">
                        <li>
                            <a href="#" class="hover:underline">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">GDPR</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Cookies</a>
                        </li>
                    </ul>
                </div>

                <!-- Partners -->
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Partners</h2>
                    <ul class="text-gray-500 font-medium flex flex-col gap-2">
                        <li>
                            <a href="/user/chat" class="hover:underline">Online Doctor</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />

        <!-- Copyright and Social Media -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <span class="text-sm text-gray-500">
                © 2025 <a href="/" class="hover:underline">ApotekAmanah™</a>. All Rights Reserved.
            </span>

            <!-- Social Media Icons -->
            <div class="flex gap-5">
                <a href="#" class="text-gray-500 hover:text-gray-900">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 8 19">
                        <path fill-rule="evenodd"
                            d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Facebook page</span>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-900">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 17">
                        <path fill-rule="evenodd"
                            d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Twitter page</span>
                </a>
            </div>
        </div>
    </div>
</footer>