<div class="w-full">
    <div class="grid gap-y-4 p-6">
        <div class="flex items-center justify-between">
            <span class="animate-pulse bg-gray-200 dark:bg-gray-700 h-3 w-28 rounded"></span>
            <span class="animate-pulse bg-gray-200 dark:bg-gray-700 h-6 w-20 rounded"></span>
        </div>

        <div class="animate-pulse bg-gray-200 dark:bg-gray-700 h-6 w-20 rounded"></div>
    </div>

    <div class="mb-4">
        <div class="absolute inset-x-0 bottom-0 overflow-hidden rounded-b-xl">
            <div class="animate-pulse bg-gray-200 dark:bg-gray-700 h-6"></div>
        </div>
    </div>
</div>
<style>
    .x-animate-wave {
        position: relative;
        overflow: hidden;
        z-index: 1;
        box-sizing: border-box;
    }
    .x-animate-wave::before {
        content: "";
    }
    .x-animate-wave::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 0;
        background: linear-gradient(90deg,hsla(0,0%,100%,0),hsla(0,0%,100%,0.5),hsla(0,0%,100%,0));
        animation: x-animate--wave 1.5s linear 0.5s infinite;
    }

    @keyframes x-animate--wave {
        0% {
            transform: translateX(-100%)
        }

        to {
            transform: translateX(100%)
        }
    }
</style>
