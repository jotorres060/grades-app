@extends ("layouts.app")
@section ("title", "Nueva calificación")
@section ("content")
    <div class="d-flex justify-content-center">
        <div class="card shadow mt-5" style="width: 60rem;">
            <div class="card-body">
                <h3 class="card-title text-center">Nueva calificación</h3>
                <hr>

                <!-- Alerts -->
                <x-alert/>

                <!-- Back -->
                <div class="mb-4 d-flex justify-content-end">
                    <a class="btn btn-outline-secondary btn-sm fw-bold" href="{{ route("grades_index") }}" title="Volver"> < Volver</a>
                </div>

                <!-- Form register -->
                <form action="{{ route("grades_store") }}" method="POST">
                    @csrf

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="name">Nombre</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="studentName" id="name" value="{{ old("name") }}" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="grade1">Parcial 1</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" name="grade1" id="grade1" value="{{ old("grade1") }}" required
                                   min="1" max="5" step="0.1" pattern="^\d+(?:\.\d{1,2})?$" onfocusout="calculateFinalGrade()">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="grade2">Parcial 2</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" name="grade2" id="grade2" value="{{ old("grade2") }}" required
                                   min="1" max="5" step="0.1" pattern="^\d+(?:\.\d{1,2})?$" onfocusout="calculateFinalGrade()">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="grade3">Parcial 3</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" name="grade3" id="grade3" value="{{ old("grade3") }}" required
                                   min="1" max="5" step="0.1" pattern="^\d+(?:\.\d{1,2})?$" onfocusout="calculateFinalGrade()">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button class="btn btn-warning btn-sm fw-bold" type="submit">Guardar</button>
                    </div>
                </form>

                <div class="mt-3 row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <h5 class="fw-bold">
                            Nota Final: <small class="text-decoration-underline" id="finalGrade">0</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push ('scripts')
    <script src="{{ asset("js/app.js") }}"></script>
@endpush
