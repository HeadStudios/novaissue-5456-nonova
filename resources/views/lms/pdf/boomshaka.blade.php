@php use Illuminate\Support\Str; @endphp
<style>
    table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

th {
  background-color: #4CAF50;
  color: white;
}

    </style>
<h1>{{ $name }} </h1>

{!! Str::markdown($content) !!}

@if ($checklists->count())
<table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Approved</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($checklists as $checklist)
                @php  @endphp
                    <tr>
                        <td>{{ $checklist->name }}</td>
                        <td>{{ $checklist->description }}</td>
                        <td>{{ $checklist->users[0]->pivot->status }}</td>
                        <td>{{ $checklist->users[0]->pivot->approved }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No checklists for this lesson</p>
@endif
