<hr>
<div class="mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active"
                id="students-tab"
                data-toggle="tab"
                href="#students"
                role="tab"
                aria-controls="students"
                aria-selected="true">Alunos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"
                id="paragraph-tab"
                data-toggle="tab"
                href="#paragraph"
                role="tab"
                aria-controls="paragraph"
                aria-selected="false">Controle de parágrafo</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link @if ($groupclass->type === \App\Models\GroupClass::TYPE_VIP) disabled @endif"
                id="frequency-tab"
                data-toggle="tab"
                href="#frequency"
                role="tab"
                aria-controls="frequency"
                aria-selected="false">Controle de presença</a>
        </li>
    </ul>
    <div class="tab-content p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="students" role="tabpanel" aria-labelledby="students-tab">

            @include('admin.class.tabs.students')
        </div>
        <div class="tab-pane fade" id="paragraph" role="tabpanel" aria-labelledby="paragraph-tab">

            @include('admin.class.tabs.paragraphs')
        </div>
        <div class="tab-pane fade" id="frequency" role="tabpanel" aria-labelledby="frequency-tab">

            @include('admin.class.tabs.frequency')
        </div>
    </div>
</div>
