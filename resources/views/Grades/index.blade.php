@extends ("layouts.app")
@section ("content")
    <div class="d-flex justify-content-center">
        <div class="card shadow mt-5" style="width: 60rem;">
            <div class="card-body">
                <h3 class="card-title text-center">Calificaciones</h3>
                <hr>

                <!-- Alerts -->
                <x-alert/>

                <!-- New register -->
                <div class="mb-2 d-flex justify-content-end">
                    <a class="btn btn-warning btn-sm fw-bold" href="{{ route("grades_create") }}" title="Nuevo">Nuevo</a>
                </div>

                <!-- Registers -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Parcial 1</th>
                                <th>Parcial 2</th>
                                <th>Parcial 3</th>
                                <th>Final</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($grades) > 0)
                                @foreach ($grades as $grade)
                                    <tr>
                                        <td>{{ $grade->student_name }}</td>
                                        <td>{{ $grade->grade_1 }}</td>
                                        <td>{{ $grade->grade_2 }}</td>
                                        <td>{{ $grade->grade_3 }}</td>
                                        <td>{{ $grade->final_grade }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a class="btn btn-outline-secondary btn-sm fw-bold me-2" href="{{ route("grades_edit", $grade->id) }}" title="Editar">Editar</a>

                                            <form action="{{ route("grades_destroy", $grade->id) }}" method="POST">
                                                @csrf
                                                @method ("DELETE")

                                                <button class="btn btn-outline-secondary btn-sm fw-bold" type="submit" title="Eliminar">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="7">
                                        <em>No se encontraron registros.</em>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                {{ $grades->links() }}
            </div>
        </div>
    </div>
@endsection
