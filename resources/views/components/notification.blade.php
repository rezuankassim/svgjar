<div
    x-data="{
        messages: [],
        sessionNotify: '{{ session()->get('notify') }}',
        remove(message) {
            this.messages.splice(this.messages.indexOf(message), 1)
        }
    }"
    x-init="() => {if (sessionNotify) { messages.push(JSON.parse(sessionNotify)); setTimeout(() => { remove(sessionNotify) }, 2500);}}"
    x-on:notify.window="console.log($event.detail); let message = $event.detail; messages.push(JSON.parse(message)); setTimeout(() => { remove(message) }, 2500)"
    class="fixed inset-0 flex flex-col items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:justify-start space-y-4 z-50"
>
    <template x-for="(message, messageIndex) in messages" :key="messageIndex">
        <div
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="max-w-sm w-full bg-green-100 shadow-green-500-lg rounded-lg pointer-events-auto"
        >
            <div class="rounded-lg shadow-green-500-xs overflow-hidden">
                <div class="px-3 py-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <x-icon.check-circle class="text-green-400" />
                        </div>

                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <div class="grid grid-flow-row gap-y-1">
                                <p x-text="message.message" class="text-sm font-semibold text-gray-900"></p>

                                <p x-text="message.submessage" class="text-sm font-medium text-gray-600"></p>
                            </div>
                        </div>

                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="remove(message)" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                                <x-icon.close class="text-green-400"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
