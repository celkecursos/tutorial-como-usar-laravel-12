@extends('layouts.site')

@section('content')
    {{-- Container principal com um fundo gradiente e configurações de flexbox para centralização --}}
    <div
        class="bg-gradient-to-r from-blue-900 to-indigo-600 min-h-screen flex flex-col justify-center items-center text-white">

        {{-- Seção de cabeçalho centralizada --}}
        <header class="text-center">

            {{-- Título principal do aplicação --}}
            <h1 class="text-3xl font-bold mb-6">Gerencie Suas Finanças Pessoais com Facilidade!</h1>

            {{-- Descrição do aplicação --}}
            <p class="text-lg mb-10">
                Controle seus gastos, organize seu orçamento e alcance seus objetivos financeiros.
            </p>

            {{-- Container para os links de ação com espaçamento --}}
            <div class="flex justify-center space-x-4">

                {{-- Verifica se o usuário está autenticado --}}
                @auth
                    <a href="{{ route('user.index') }}"
                        class="bg-blue-900 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Acessar
                    </a>

                    <a href="{{ route('login') }}"
                        class="bg-blue-900 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Cadastrar
                    </a>
                @endauth

            </div>

        </header>

        {{-- Seção com informações adicionais sobre o aplicativo --}}
        <section class="mt-12 flex flex-col md:flex-row justify-center items-center space-y-6 md:space-y-0 md:space-x-6">

            {{-- Descrição do primeiro recurso --}}
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-72 text-center">
                <h3 class="font-bold text-xl mb-4">Controle Simples</h3>
                <p>
                    Monitore todas as suas despesas e receitas com facilidade, garantindo total controle.
                </p>
            </div>

            {{-- Descrição do primeiro recurso --}}
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-72 text-center">
                <h3 class="font-bold text-xl mb-4">Relatórios Detalhados</h3>
                <p>
                    Visualize gráficos e relatórios que ajudam a entender melhor seus hábitos financeiros.
                </p>
            </div>

            {{-- Descrição do primeiro recurso --}}
            <div class="bg-white text-black p-6 rounded-lg shadow-lg w-72 text-center">
                <h3 class="font-bold text-xl mb-4">Planejamento de Metas</h3>
                <p>
                    Defina metas de economia e veja como seu progresso avança no dia a dia.
                </p>
            </div>

        </section>

        {{-- Seção do rodapé --}}
        <footer class="mt-16 text-center">
            {{-- Exibe o ano atual e o nome do aplicativo --}}
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
        </footer>

    </div>
@endsection
