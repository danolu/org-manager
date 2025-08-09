<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4">{{ $position->name }} - Results</h2>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidate</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Yes Votes</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No Votes</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($results as $row)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $row['candidate']->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $row['yes_votes'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $row['no_votes'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900"><strong>{{ $row['total_votes'] }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('results') }}" class="btn-secondary">Back to All Results</a>
    </div>
</div>
