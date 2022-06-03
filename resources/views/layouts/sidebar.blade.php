<aside class='sidebar'>
  <div class='info'>
    <img src="{{ asset('images/logoatt.svg')}}" alt="">

    <div class='text-info'>
      <p>Bem-vindo,</p>
      <strong title="{{auth()->user()->name}}">{{auth()->user()->name}}</strong>
    </div>

  </div>
  <ul class="list-unstyled components">
      <li class="{{ request()->routeIs('home*') ? 'active' : '' }}">
      <a href="{{ route('home')}}">
            <i class="material-icons">dashboard</i>
            Dashboard</a>
      </li>

      @canany(['access class', 'access books', 'access students'])
        @php
          $recepcaoActive = request()->routeIs("students*") ||
                            request()->routeIs("books*") ||
                            request()->routeIs("class*") ? true : false;
        @endphp
        <li class="{{ $recepcaoActive ? 'active' : ''}}">
            <a href="#recepcaoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
              <i class="material-icons">playlist_add_check</i>
              Recepção
            </a>
            <ul class="collapse list-unstyled {{ $recepcaoActive ? 'show' : ''}}" id="recepcaoSubmenu">

                @can('access students')
                  <li class="{{ request()->routeIs("students*") ? 'active' : '' }}">
                      <a href="{{ route('students.index')}}">Alunos</a>
                  </li>
                @endcan

                @can('access class')
                <li class="{{ request()->routeIs("class*") ? 'active' : '' }}">
                    <a href="{{ route('class.index')}}">Turma</a>
                </li>
                @endcan

                @can('access books')
                <li class="{{ request()->routeIs("books*") ? 'active' : '' }}">
                    <a href="{{ route('books.index')}}">Books</a>
                </li>
                @endcan
            </ul>
        </li>
      @endcan


      @canany(['access schedule', 'access contracts'])
        @php
          $atendimentoActive = request()->routeIs("schedules*") ||
                              request()->routeIs("contracts*") ||
                              request()->routeIs("after-sales*") ? true : false;
        @endphp
        <li class="{{ $atendimentoActive ? 'active' : ''}}">
          <a href="#atendimentoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">contact_phone</i>
            Atendimento
          </a>
          <ul class="collapse list-unstyled {{ $atendimentoActive ? 'show': '' }}" id="atendimentoSubmenu">
              @can('access schedule')
                <li class="{{ request()->routeIs("schedules*") ? 'active' : '' }}">
                    <a href="{{ route('schedules.index') }}">Agendamentos</a>
                </li>
              @endcan

              @can('access contracts')
              <li class="{{ request()->routeIs("contracts*") ? 'active' : '' }}">
                  <a href="{{ route('contracts.index')}}">Contratos</a>
              </li>
              @endcan

          </ul>
        </li>
      @endcan

        @php
            $storeActive = request()->routeIs("prospects*") ||
                           request()->routeIs("remarketing*") ||
                           request()->routeIs("after-sales*") ? true : false;
        @endphp

      <li class="{{ $storeActive ? 'active' : ''}}">
        <a href="#vendasSubmenu" data-toggle="collapse" aria-expanded="false" class='dropdown-toggle'>
          <i class='material-icons'>store</i>
          Vendas
        </a>
        <ul class='collapse list-unstyled {{ $storeActive ? 'show' : ''}}' id="vendasSubmenu">
          {{-- @can('access after sales') --}}
          <li class="{{ request()->routeIs("prospects*") ? 'active' : '' }}">
              <a href="{{ route('prospects.index')}}">Prospectos</a>
          </li>

          <li class="{{ request()->routeIs("remarketing*") ? 'active' : '' }}">
              <a href="{{ route('remarketing.index')}}">Remarketing</a>
          </li>
          {{-- @endcan --}}

          @can('access after sales')
          <li class="{{ request()->routeIs("after-sales*") ? 'active' : '' }}">
              <a href="#"><s>Pós Venda</s></a>
          </li>
          @endcan
        </ul>
      </li>


      @canany(['access cashflow', 'access entries', 'access categories'])
        @php
          $financeiroActive = request()->routeIs("cashflow*") ||
                              request()->routeIs("categories*") ||
                              request()->routeIs("sub-categories*") ||
                              request()->routeIs("entries*") ||
                              request()->routeIs("bills*") ||
                              request()->routeIs("receipts*") ||
                              request()->routeIs("finance*") ? true : false;
        @endphp
        <li class="{{ $financeiroActive ? 'active' : ''}}">
          <a href="#financeiroSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">account_balance_wallet</i>
            Financeiro
          </a>
          <ul class="collapse list-unstyled {{ $financeiroActive ? 'show': '' }}" id="financeiroSubmenu">

              @can('access cashflow')
              <li class="{{ request()->routeIs("cashflow*") ? 'active' : '' }}">
                  <a href="{{ route('cashflow.index')}}">Visão Geral</a>
              </li>
              @endcan

              {{-- @can('access entries')
              <li class="{{ request()->routeIs("entries*") ? 'active' : '' }}">
                  <a href="{{ route('entries.index')}}">Lançamentos</a>
              </li>
              @endcan --}}

              @can('access categories')
              <li class="{{ (request()->routeIs("categories*") || request()->routeIs("categories*")) ? 'active' : '' }}">
                  <a href="{{ route('categories.index')}}">Categorias</a>
              </li>
              @endcan

              <li class="{{ (request()->routeIs("bills*") || request()->routeIs("bills*")) ? 'active' : '' }}">
                  <a href="{{ route('bills.index')}}">Contas a pagar</a>
              </li>

              <li class="{{ (request()->routeIs("receipts*") || request()->routeIs("receipts*")) ? 'active' : '' }}">
                  <a href="{{ route('receipts.index')}}">Contas a receber</a>
              </li>
          </ul>
        </li>
      @endcan

      {{-- @can('reports') --}}
        @php
          $reportActive = request()->routeIs("reports*") ? true : false;
        @endphp
      <li class="{{ $reportActive ? 'active' : ''}}">
        <a href="#reportsSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
          <i class="material-icons">assignment</i>
          Relatórios
        </a>
        <ul class="collapse list-unstyled {{ $reportActive ? 'show': '' }}"  id="reportsSubMenu">
            <li class="{{ request()->routeIs("reports.students*") ? 'active' : '' }}">
                <a href="{{ route('reports.students.create')}}">Alunos</a>
            </li>
            <li class="{{ request()->routeIs("reports.teachers*") ? 'active' : '' }}">
                <a href="{{ route('reports.teachers.create') }}">Professores</a>
            </li>
            <li class="{{ request()->routeIs("reports.receipts*") ? 'active' : '' }}">
                <a href="{{ route('reports.receipts.create') }}">Recibos</a>
            </li>
        </ul>
      </li>
      {{-- @endcan --}}

      @canany(['access ussers', 'access teachers', 'access origins'])
        @php
          $geralActive = request()->routeIs("users*") ||
                        request()->routeIs("teachers*") ||
                        request()->routeIs("roles*") ||
                        request()->routeIs("payment-methods*") ||
                        request()->routeIs("contracts-models*") ||
                        request()->routeIs("origins*") ? true : false;
        @endphp
        <li class="{{ $geralActive ? 'active' : ''}}">
          <a href="#geralSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="material-icons">more_horiz</i>
            Geral
          </a>
          <ul class="collapse list-unstyled {{ $geralActive ? 'show': '' }}"  id="geralSubmenu">
            @can('access users')
              <li class="{{ request()->routeIs("users*") ? 'active' : '' }}">
                  <a href="{{ route('users.index')}}">Usuários</a>
              </li>
            @endcan

            @can('access teachers')
              <li class="{{ request()->routeIs("teachers*") ? 'active' : '' }}">
                  <a href="{{ route('teachers.index')}}">Professores</a>
              </li>
            @endcan

            @can('access origins')
            <li class="{{ request()->routeIs('origins*') ? 'active' : '' }}">
              <a href="{{ route('origins.index')}}">Origens de Cadastro</a>
            </li>
            @endcan


            @if (auth()->user()->role('Super Admin'))
                <li class="{{ request()->routeIs('roles*') ? 'active' : '' }}">
                <a href="{{ route('roles.index')}}">Funções</a>
                </li>
            @endif

            @if (auth()->user()->role('Super Admin'))
                <li class="{{ request()->routeIs('payment-methods*') ? 'active' : '' }}">
                    <a href="{{ route('payment-methods.index')}}">Formas de pagamento</a>
                </li>
            @endif

            @if (auth()->user()->role('Super Admin'))
                <li class="{{ request()->routeIs('contracts-models*') ? 'active' : '' }}">
                <a href="{{ route('contracts-models.index')}}">Modelos de contrato</a>
                </li>
            @endif
          </ul>
        </li>
      @endcan

      @can('edit site info')
        @php
          $siteActive = Route::currentRouteName() == 'admin.siteconfig.edit' ? true : false;
        @endphp
      <li class="{{ $siteActive ? 'active' : ''}}">
        <a href="#siteSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
          <i class="material-icons">public</i>
          Site
        </a>
        <ul class="collapse list-unstyled {{ $siteActive ? 'show': '' }}"  id="siteSubmenu">
          @can('edit site info')
            <li class="{{ Route::currentRouteName() == 'admin.siteconfig.edit' ? 'active' : '' }}">
                <a href="{{route('admin.siteconfig.edit', 1)}}">Contato do site</a>
            </li>
          @endcan
        </ul>
      </li>
      @endcan



    @can('access settings')
        <li class="{{ request()->routeIs('settings*') ? 'active' : '' }}">
            <a href="{{ route('settings.index')}}">
                <i class="material-icons">settings</i>
                Configurações</a>
        </li>
    @endcan

    {{-- @can('access settings') --}}
        <li class="{{ request()->routeIs('settings*') ? 'active' : '' }}">
            <a href="{{ route('settings.index')}}">
                <i class="material-icons">backup</i>
                Backup</a>
        </li>
    {{-- @endcan --}}
  </ul>
</aside>
