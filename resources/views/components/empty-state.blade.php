@props(['label' => 'Belum ada data', 'colspan' => 1])
<tr>
    <td colspan="{{ $colspan }}" class="py-14 text-center">
        <div class="flex flex-col items-center gap-2 text-slate-400">
            <svg class="h-12 w-12 text-purple-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
            <p class="text-sm font-medium">{{ $label }}</p>
        </div>
    </td>
</tr>