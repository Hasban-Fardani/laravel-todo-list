<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Simple Todo</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen" data-theme="light">
    <header>
        <div class="navbar bg-base-100 shadow-md">
            <div class="flex-1">
                <a class="btn btn-ghost text-xl">Todo List</a>
            </div>
            <div class="flex-none">
                @auth
                    <ul class="menu menu-horizontal px-1">
                        <li>
                            <form action="/logout" method="POST">@csrf<input type="submit" value="Logout"></form>
                        </li>
                    </ul>
                @else
                    <ul class="menu menu-horizontal px-1">
                        <li><button onclick="login_modal.showModal()">Login</button></li>
                    </ul>

                    <ul class="menu menu-horizontal px-1">
                        <li><button onclick="register_modal.showModal()">Register</button></li>
                    </ul>
                @endauth
            </div>
        </div>
    </header>
    <main class="text-center px-52 relative">
        {{-- Alert section --}}
        <section class="mt-6">
            @if ($s = session('success'))
                <div role="alert"
                    class="alert alert-success animate-fade-in-down absolute top-0 right-[10vw] z-50 w-[80vw]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $s }}</span>
                    <button onclick="this.parentElement.remove()" class="btn btn-sm bg-transparent border-none">x</button>
                </div>
            @elseif ($s2 = session('error'))
                <div role="alert"
                    class="alert alert-error animate-fade-in-down absolute top-0 right-[10vw] z-50 w-[80vw]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $s2 }}</span>
                    <button onclick="this.parentElement.remove()" class="btn btn-sm bg-transparent border-none">x</button>
                </div>
            @endif
        </section>
        {{-- End Alert section --}}


        {{-- Data section --}}
        <section class="flex flex-col items-center justify-center mt-12">
            @auth
                <form action="/todos" method="POST" class="flex justify-center gap-2">
                    @csrf
                    <input type="text" name="title" placeholder="Todo Title" class="input input-bordered">
                    <input type="text" name="description" placeholder="Todo Description" class="input input-bordered">
                    <button type="submit" class="btn btn-primary">Add Todo</button>
                </form>

                <table class="table w-4/5 mt-12">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$todos->isEmpty())
                            @foreach ($todos as $todo)
                                <tr>
                                    <td>{{ $todo->title }}</td>
                                    <td>{{ $todo->description }}</td>
                                    <td>{{ $todo->status }}</td>
                                    <td class="flex gap-1">
                                        <button class="btn btn-warning btn-sm"
                                            onclick="editTodo({{ $todo->id }}, '{{ $todo->title }}', '{{ $todo->description }}')">Edit</button>
                                        <form action="/todos/{{ $todo->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-error btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">- No Todo -</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @else
                <p class="flex justify-center items-center h-[80vh] text-lg font-semibold">- Plese Login -</p>
            @endauth
        </section>


        {{-- Dialog section --}}
        <section>
            <dialog id="login_modal" class="modal">
                <form class="modal-box form-control w-64" action="/login" method="POST">
                    @csrf
                    <h3 class="font-bold text-lg">Login</h3>
                    <div class="label">
                        <label for="login_email" class="label-text">Email</label>
                    </div>
                    <input type="email" name="email" id="login_email" placeholder="example@mail.co"
                        class="input input-bordered w-full max-w-xs" required />

                    <div class="label">
                        <label for="register_password" class="label-text">Password</label>
                    </div>
                    <input type="password" name="password" id="register_password" placeholder="***"
                        class="input input-bordered w-full max-w-xs" required />
                    <div class="modal-action ">

                        <!-- if there is a button in form, it will close the modal -->
                        <button type="button" class="btn" onclick="login_modal.close(); event.preventDefault()">Cancel</button>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </dialog>

            <dialog id="register_modal" class="modal">
                <form class="modal-box form-control w-64" action="/register" method="POST">
                    @csrf
                    <h3 class="font-bold text-lg">Register</h3>
                    <div class="label">
                        <label for="register_name" class="label-text">Name</label>
                    </div>
                    <input type="name" name="name" id="register_name" placeholder="name ..."
                        class="input input-bordered w-full max-w-xs" required />


                    <div class="label">
                        <label for="register_email" class="label-text">Email</label>
                    </div>
                    <input type="email" name="email" id="register_email" placeholder="example@mail.co"
                        class="input input-bordered w-full max-w-xs" required />

                    <div class="label">
                        <label for="login_password" class="label-text">Password</label>
                    </div>
                    <input type="password" name="password" id="login_password" placeholder="***"
                        class="input input-bordered w-full max-w-xs" required />
                    <div class="modal-action ">

                        <!-- if there is a button in form, it will close the modal -->
                        <button type="button" class="btn" onclick="register_modal.close(); event.preventDefault()">Cancel</button>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </dialog>

            <dialog id="edit_modal" class="modal">
                <form class="modal-box form-control w-64" action="/todos" method="POST">
                    @csrf
                    @method('PUT')
                    <h3 class="font-bold text-lg">Edit Todo</h3>
                    <input type="text" name="id" id="edit_id" value="" class="hidden">
                    <input type="text" name="title" id="edit_title" value="" class="input input-bordered w-full max-w-xs mt-3">
                    <input type="text" name="description" id="edit_description" value="" class="input input-bordered w-full max-w-xs mt-3">
                    <div class="modal-action ">

                        <!-- if there is a button in form, it will close the modal -->
                        <button type="button" class="btn" onclick="edit_modal.close(); event.preventDefault()">Cancel</button>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </dialog>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function editTodo(id, title, description) {
            edit_modal.showModal();
            edit_id.value = id;
            edit_title.value = title;
            edit_description.value = description;
        }

        function getSelectedTodo() {
            return selectedTodo;
        }

        let alerts = document.querySelectorAll('.alert');
        setTimeout(() => {
            alerts.forEach((alert) => {
                // hide alert
                alert.classList.remove('animate-fade-in-down');
                alert.classList.add('animate-fade-out-up');

                setTimeout(() => {
                    // remove alert
                    alert.remove();
                }, 500);
            })
        }, 3000);

        addEventListener('keydown', ({
            key
        }) => {
            if (key === 'enter') {
                document.querySelector('form').submit();
            }
        })

        function createToken() {
            // create xhr requests post to route /api/token/create
            
        }
    </script>
</body>

</html>
