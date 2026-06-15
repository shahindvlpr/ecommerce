<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">

    <div class="container-fluid">

        <span class="navbar-brand">

            Admin Panel

        </span>

        <div class="ms-auto">

            <span class="me-3">

                Welcome,
                {{ Auth::user()->name ?? 'Admin' }}

            </span>

            <form action="{{ route('logout') }}"
                  method="POST"
                  class="d-inline">

                @csrf

                <button class="btn btn-danger btn-sm">

                    Logout

                </button>

            </form>

        </div>

    </div>

</nav>