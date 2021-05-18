{{-- Allows for block blades to be in either the main project or loaded from the cms package --}}
@includeFirst(['stack.block.' . $type . '.edit', 'cms::stack.block.' . $type . '.edit'])