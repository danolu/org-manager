<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Election Results</h1>

    @if(count($results) === 0)
        <div class="text-center py-8">
            <p class="text-gray-500">No results available yet.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($results as $result)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">{{ $result['position']->name }}</h2>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Votes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($result['results'] as $row)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $row['candidate']->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900"><strong>{{ $row['votes'] }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="btn-secondary">Back to Dashboard</a>
    </div>
</div>
