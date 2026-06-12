# CSS por Tela - Guia de Organização

## Estrutura

Esta pasta contém arquivos CSS organizados especificamente para cada tela/módulo do projeto.

### Hierarquia de Importação

O arquivo principal `resources/css/app.css` importa todos os arquivos nesta ordem:

1. **layouts.css** - Estilos gerais de navegação e containers
2. **components.css** - Componentes reutilizáveis
3. **auth.css** - Telas de autenticação (login, register, etc.)
4. **dashboard.css** - Dashboard principal
5. **profile.css** - Perfil de usuário
6. **fichas.css** - Fichas de personagem
7. **inventario.css** - Inventário do jogador
8. **chibis.css** - Gerenciamento de personagens
9. **banco.css** - Sistema bancário
10. **categorias.css** - Gerenciamento de categorias
11. **passe.css** - Sistema de passe de batalha
12. **loja.css** - Loja/shop
13. **rng.css** - Sistema RNG/gacha
14. **admin.css** - Páginas administrativas

## Como Adicionar Estilos

### Para uma Tela Existente

1. Abra o arquivo CSS correspondente (ex: `fichas.css`)
2. Adicione seus estilos dentro do `@layer components { }`
3. Use Tailwind CSS utilities quando possível

### Exemplo

```css
/* fichas.css */
@layer components {
    .ficha-card {
        @apply bg-white rounded-lg shadow-lg p-6;
    }

    .ficha-grid {
        @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4;
    }
}
```

## Boas Práticas

1. **Não misture estilos** - Mantenha cada tela/módulo em seu arquivo
2. **Use @layer components** - Garante especificidade correta com Tailwind
3. **Aproveite Tailwind** - Use utilities antes de escrever CSS customizado
4. **Nomeação consistente** - Use prefixos que identifiquem a tela (ex: `ficha-`, `inventory-`)
5. **Evite !important** - Use @layer para controlar especificidade

## Entrypoint

O arquivo `resources/css/app.css` é o entry point carregado pelo Vite. Todas as importações são feitas lá.

## Manutenção

- Se uma tela for removida, remova seu arquivo CSS e a import correspondente em `app.css`
- Se uma nova tela for adicionada, crie seu arquivo CSS e adicione a import em `app.css`
- Mantenha a ordem alfabética para melhor organização
