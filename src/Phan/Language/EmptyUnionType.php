<?php declare(strict_types=1);
namespace Phan\Language;

use Phan\CodeBase;
use Phan\Language\Type\ArrayType;

/**
 * NOTE: there may also be instances of UnionType that are empty, due to the constructor being public
 *
 * @phan-file-suppress PhanPluginUnusedPublicFinalMethodArgument the results don't depend on passed in parameters
 */
final class EmptyUnionType extends UnionType
{
    /**
     * An optional list of types represented by this union
     * @internal
     */
    public function __construct()
    {
        parent::__construct([], true);
    }

    /**
     * Use UnionType::empty() instead elsewhere in the codebase.
     */
    protected static function instance() : EmptyUnionType
    {
        static $self = null;
        return $self ?? ($self = new EmptyUnionType());
    }

    /**
     * @return Type[]
     * The list of simple types associated with this
     * union type. Keys are consecutive.
     * @override
     */
    public function getTypeSet() : array
    {
        return [];
    }

    /**
     * Add a type name to the list of types
     *
     * @return UnionType
     * @override
     */
    public function withType(Type $type)
    {
        return $type->asUnionType();
    }

    /**
     * Returns a new union type
     * which removes this type from the list of types,
     * keeping the keys in a consecutive order.
     *
     * Each type in $this->type_set occurs exactly once.
     *
     * @return UnionType
     * @override
     */
    public function withoutType(Type $type)
    {
        return $this;
    }

    /**
     * @return bool
     * True if this union type contains the given named
     * type.
     * @override
     */
    public function hasType(Type $type) : bool
    {
        return false;
    }

    /**
     * Returns a union type which add the given types to this type
     *
     * @return UnionType
     * @override
     */
    public function withUnionType(UnionType $union_type)
    {
        return $union_type;
    }

    /**
     * @return bool
     * True if this type has a type referencing the
     * class context in which it exists such as 'self'
     * or '$this'
     * @override
     */
    public function hasSelfType() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this union type has any types that are bool/false/true types
     * @override
     */
    public function hasTypeInBoolFamily() : bool
    {
        return false;
    }

    /**
     * @return UnionType[]
     * A map from template type identifiers to the UnionType
     * to replace it with
     * @override
     */
    public function getTemplateParameterTypeList() : array
    {
        return [];
    }

    /**
     * @param CodeBase $code_base
     * The code base to look up classes against
     *
     * TODO: Defer resolving the template parameters until parse ends. Low priority.
     *
     * @return UnionType[]
     * A map from template type identifiers to the UnionType
     * to replace it with
     */
    public function getTemplateParameterTypeMap(
        CodeBase $code_base
    ) : array {
        return [];
    }


    /**
     * @param UnionType[] $template_parameter_type_map
     * A map from template type identifiers to concrete types
     *
     * @return UnionType
     * This UnionType with any template types contained herein
     * mapped to concrete types defined in the given map.
     */
    public function withTemplateParameterTypeMap(
        array $template_parameter_type_map
    ) : UnionType {
        return $this;
    }

    /**
     * @return bool
     * True if this union type has any types that are generic
     * types
     * @override
     */
    public function hasTemplateType() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this type has a type referencing the
     * class context 'static'.
     * @override
     */
    public function hasStaticType() : bool
    {
        return false;
    }

    /**
     * @return UnionType
     * A new UnionType with any references to 'static' resolved
     * in the given context.
     */
    public function withStaticResolvedInContext(
        Context $context
    ) : UnionType {
        return $this;
    }

    /**
     * @return bool
     * True if and only if this UnionType contains
     * the given type and no others.
     * @override
     */
    public function isType(Type $type) : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this UnionType is exclusively native
     * types
     * @override
     */
    public function isNativeType() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True iff this union contains the exact set of types
     * represented in the given union type.
     * @override
     */
    public function isEqualTo(UnionType $union_type) : bool
    {
        return $union_type->isEmpty();
    }

    /**
     * @return bool
     * True iff this union contains a type that's also in
     * the other union type.
     */
    public function hasCommonType(UnionType $union_type) : bool
    {
        return false;
    }

    /**
     * @return bool - True if not empty and at least one type is NullType or nullable.
     */
    public function containsNullable() : bool
    {
        return false;
    }

    /** @override */
    public function nonNullableClone() : UnionType
    {
        return $this;
    }

    /** @override */
    public function nullableClone() : UnionType
    {
        return $this;
    }

    /**
     * @return bool - True if type set is not empty and at least one type is NullType or nullable or FalseType or BoolType.
     * (I.e. the type is always falsey, or both sometimes falsey with a non-falsey type it can be narrowed down to)
     * This does not include values such as `IntType`, since there is currently no `NonZeroIntType`.
     * @override
     */
    public function containsFalsey() : bool
    {
        return false;
    }

    /** @override */
    public function nonFalseyClone() : UnionType
    {
        return $this;
    }

    /**
     * @return bool - True if type set is not empty and at least one type is NullType or nullable or FalseType or BoolType.
     * (I.e. the type is always falsey, or both sometimes falsey with a non-falsey type it can be narrowed down to)
     * This does not include values such as `IntType`, since there is currently no `NonZeroIntType`.
     * @override
     */
    public function containsTruthy() : bool
    {
        return false;
    }

    /** @override */
    public function nonTruthyClone() : UnionType
    {
        return $this;
    }

    /**
     * @return bool - True if type set is not empty and at least one type is BoolType or FalseType
     * @override
     */
    public function containsFalse() : bool
    {
        return false;
    }

    /**
     * @return bool - True if type set is not empty and at least one type is BoolType or TrueType
     * @override
     */
    public function containsTrue() : bool
    {
        return false;
    }

    public function nonFalseClone() : UnionType
    {
        return $this;
    }

    public function nonTrueClone() : UnionType
    {
        return $this;
    }

    /**
     * @param UnionType $union_type
     * A union type to compare against
     *
     * @param Context $context
     * The context in which this type exists.
     *
     * @param CodeBase $code_base
     * The code base in which both this and the given union
     * types exist.
     *
     * @return bool
     * True if each type within this union type can cast
     * to the given union type.
     */
    // Currently unused and buggy, commenting this out.
    /**
    public function isExclusivelyNarrowedFormOrEquivalentTo(
        UnionType $union_type,
        Context $context,
        CodeBase $code_base
    ) : bool {

        // Special rule: anything can cast to nothing
        // and nothing can cast to anything
        if ($union_type->isEmpty() || $this->isEmpty()) {
            return true;
        }

        // Check to see if the types are equivalent
        if ($this->isEqualTo($union_type)) {
            return true;
        }
        // TODO: Allow casting MyClass<TemplateType> to MyClass (Without the template?

        // Resolve 'static' for the given context to
        // determine whats actually being referred
        // to in concrete terms.
        $other_resolved_type =
            $union_type->withStaticResolvedInContext($context);
        $other_resolved_type_set = $other_resolved_type->type_set;

        // Convert this type to a set of resolved types to iterate over.
        $this_resolved_type_set =
            $this->withStaticResolvedInContext($context)->type_set;

        // TODO: Need to resolve expanded union types (parents, interfaces) of classes *before* this is called.

        // Test to see if every single type in this union
        // type can cast to the given union type.
        foreach ($this_resolved_type_set as $type) {
            // First check if this contains the type as an optimization.
            if ($other_resolved_type_set->contains($type)) {
                continue;
            }
            $expanded_types = $type->asExpandedTypes($code_base);
            if ($other_resolved_type->canCastToUnionType(
                $expanded_types
            )) {
                continue;
            }
        }
        return true;
    }
     */

    /**
     * @param Type[] $type_list
     * A list of types
     *
     * @return bool
     * True if this union type contains any of the given
     * named types
     */
    public function hasAnyType(array $type_list) : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this type has any subtype of `iterable` type (e.g. Traversable, Array).
     */
    public function hasIterable() : bool
    {
        return false;
    }

    /**
     * @return int
     * The number of types in this union type
     */
    public function typeCount() : int
    {
        return 0;
    }

    /**
     * @return bool
     * True if this Union has no types
     */
    public function isEmpty() : bool
    {
        return true;
    }

    /**
     * @param UnionType $target
     * The type we'd like to see if this type can cast
     * to
     *
     * @param CodeBase $code_base
     * The code base used to expand types
     *
     * @return bool
     * Test to see if this type can be cast to the
     * given type after expanding both union types
     * to include all ancestor types
     *
     * TODO: ensure that this is only called after the parse phase is over.
     */
    public function canCastToExpandedUnionType(
        UnionType $target,
        CodeBase $code_base
    ) : bool {
        return true;  // Empty can cast to anything.
    }

    /**
     * @param UnionType $target
     * A type to check to see if this can cast to it
     *
     * @return bool
     * True if this type is allowed to cast to the given type
     * i.e. int->float is allowed  while float->int is not.
     */
    public function canCastToUnionType(
        UnionType $target
    ) : bool {
        return true;  // Empty can cast to anything. See parent implementation.
    }

    /**
     * @return bool
     * True if all types in this union are scalars
     */
    public function isScalar() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this union has array-like types (is of type array, is
     * a generic array, or implements ArrayAccess).
     */
    public function hasArrayLike() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this union has array-like types (is of type array, is
     * a generic array, or implements ArrayAccess).
     */
    public function hasGenericArray() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this union contains the ArrayAccess type.
     * (Call asExpandedTypes() first to check for subclasses of ArrayAccess)
     */
    public function hasArrayAccess() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this union contains the Traversable type.
     * (Call asExpandedTypes() first to check for subclasses of Traversable)
     */
    public function hasTraversable() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this union type represents types that are
     * array-like, and nothing else (e.g. can't be null).
     * If any of the array-like types are nullable, this returns false.
     */
    public function isExclusivelyArrayLike() : bool
    {
        return false;
    }

    /**
     * @return bool
     * True if this union type represents types that are arrays
     * or generic arrays, but nothing else.
     * @suppress PhanUnreferencedPublicMethod
     */
    public function isExclusivelyArray() : bool
    {
        return false;
    }

    /**
     * @return UnionType
     * Get the subset of types which are not native
     */
    public function nonNativeTypes() : UnionType
    {
        return $this;
    }

    /**
     * A memory efficient way to create a UnionType from a filter operation.
     * If this the filter preserves everything, returns $this instead
     */
    public function makeFromFilter(\Closure $cb) : UnionType
    {
        return $this;  // filtering empty results in empty
    }

    /**
     * @param Context $context
     * The context in which we're resolving this union
     * type.
     *
     * @return \Generator
     *
     * A list of class FQSENs representing the non-native types
     * associated with this UnionType
     *
     * @throws CodeBaseException
     * An exception is thrown if a non-native type does not have
     * an associated class
     *
     * @throws IssueException
     * An exception is thrown if static is used as a type outside of an object
     * context
     *
     * TODO: Add a method to ContextNode to directly get FQSEN instead?
     */
    public function asClassFQSENList(
        Context $context
    ) {
        if (false) {
            yield null;
        }
    }

    /**
     * @param CodeBase $code_base
     * The code base in which to find classes
     *
     * @param Context $context
     * The context in which we're resolving this union
     * type.
     *
     * @return \Generator
     *
     * A list of classes representing the non-native types
     * associated with this UnionType
     *
     * @throws CodeBaseException
     * An exception is thrown if a non-native type does not have
     * an associated class
     *
     * @throws IssueException
     * An exception is thrown if static is used as a type outside of an object
     * context
     */
    public function asClassList(
        CodeBase $code_base,
        Context $context
    ) {
        if (false) {
            yield null;  // This is a generator yielding 0 results. This works around a bug in tolerant-php-parser 0.0.9
        }
    }

    /**
     * Takes "a|b[]|c|d[]|e" and returns "a|c|e"
     *
     * @return UnionType
     * A UnionType with generic array types filtered out
     *
     * @suppress PhanUnreferencedPublicMethod
     */
    public function nonGenericArrayTypes() : UnionType
    {
        return $this;
    }

    /**
     * Takes "a|b[]|c|d[]|e" and returns "b[]|d[]"
     *
     * @return UnionType
     * A UnionType with generic array types kept, other types filtered out.
     *
     * @see nonGenericArrayTypes
     */
    public function genericArrayTypes() : UnionType
    {
        return $this;
    }

    /**
     * Takes "MyClass|int|array|?object" and returns "MyClass|?object"
     *
     * @return UnionType
     * A UnionType with known object types kept, other types filtered out.
     *
     * @see nonGenericArrayTypes
     */
    public function objectTypes() : UnionType
    {
        return $this;
    }

    /**
     * Returns true if objectTypes would be non-empty.
     *
     * @return bool
     */
    public function hasObjectTypes() : bool
    {
        return false;
    }

    /**
     * Returns the types for which is_scalar($x) would be true.
     * This means null/nullable is removed.
     * Takes "MyClass|int|?bool|array|?object" and returns "int|bool"
     * Takes "?MyClass" and returns an empty union type.
     *
     * @return UnionType
     * A UnionType with known scalar types kept, other types filtered out.
     *
     * @see nonGenericArrayTypes
     */
    public function scalarTypes() : UnionType
    {
        return $this;
    }

    /**
     * Returns the types for which is_callable($x) would be true.
     * TODO: Check for __invoke()?
     * Takes "Closure|false" and returns "Closure"
     * Takes "?MyClass" and returns an empty union type.
     *
     * @return UnionType
     * A UnionType with known callable types kept, other types filtered out.
     *
     * @see nonGenericArrayTypes
     */
    public function callableTypes() : UnionType
    {
        return $this;
    }

    /**
     * Returns true if this has one or more callable types
     * TODO: Check for __invoke()?
     * Takes "Closure|false" and returns true
     * Takes "?MyClass" and returns false
     *
     * @return bool
     * A UnionType with known callable types kept, other types filtered out.
     *
     * @see $this->callableTypes()
     *
     * @suppress PhanUnreferencedPublicMethod
     */
    public function hasCallableType() : bool
    {
        return false;  // has no types
    }

    /**
     * Returns true if every type in this type is callable.
     * TODO: Check for __invoke()?
     * Takes "callable" and returns true
     * Takes "callable|false" and returns false
     *
     * @return bool
     * A UnionType with known callable types kept, other types filtered out.
     *
     * @see nonGenericArrayTypes
     */
    public function isExclusivelyCallable() : bool
    {
        return true; // !$this->hasTypeMatchingCallback(empty)
    }

    /**
     * Takes "a|b[]|c|d[]|e|array|ArrayAccess" and returns "a|c|e|ArrayAccess"
     *
     * @return UnionType
     * A UnionType with generic types(as well as the non-generic type "array")
     * filtered out.
     *
     * @see nonGenericArrayTypes
     */
    public function nonArrayTypes() : UnionType
    {
        return $this;
    }

    /**
     * @return bool
     * True if this is exclusively generic types
     */
    public function isGenericArray() : bool
    {
        return false;  // empty
    }

    /**
     * @return bool
     * True if any of the types in this UnionType made $matcher_callback return true
     */
    public function hasTypeMatchingCallback(\Closure $matcher_callback) : bool
    {
        return false;
    }

    /**
     * @return Type|false
     * Returns the first type in this UnionType made $matcher_callback return true
     */
    public function findTypeMatchingCallback(\Closure $matcher_callback)
    {
        return false;  // empty, no types
    }

    /**
     * Takes "a|b[]|c|d[]|e" and returns "b|d"
     *
     * @return UnionType
     * The subset of types in this
     */
    public function genericArrayElementTypes() : UnionType
    {
        return $this; // empty
    }

    /**
     * Takes "b|d[]" and returns "b[]|d[][]"
     *
     * @param int $key_type
     * Corresponds to the type of the array keys. Set this to a GenericArrayType::KEY_* constant.
     *
     * @return UnionType
     * The subset of types in this
     */
    public function elementTypesToGenericArray(int $key_type) : UnionType
    {
        return $this;
    }

    /**
     * @param \Closure $closure
     * A closure mapping `Type` to `Type`
     *
     * @return UnionType
     * A new UnionType with each type mapped through the
     * given closure
     */
    public function asMappedUnionType(\Closure $closure) : UnionType
    {
        return $this;  // empty
    }

    /**
     * @param int $key_type
     * Corresponds to the type of the array keys. Set this to a GenericArrayType::KEY_* constant.
     *
     * @return UnionType
     * Get a new type for each type in this union which is
     * the generic array version of this type. For instance,
     * 'int|float' will produce 'int[]|float[]'.
     *
     * If $this is an empty UnionType, this method will produce an empty UnionType
     */
    public function asGenericArrayTypes(int $key_type) : UnionType
    {
        return $this;  // empty
    }

    /**
     * @return UnionType
     * Get a new type for each type in this union which is
     * the generic array version of this type. For instance,
     * 'int|float' will produce 'int[]|float[]'.
     *
     * If $this is an empty UnionType, this method will produce 'array'
     */
    public function asNonEmptyGenericArrayTypes(int $key_type) : UnionType
    {
        return ArrayType::instance(false)->asUnionType();
    }

    /**
     * @param CodeBase
     * The code base to use in order to find super classes, etc.
     *
     * @param $recursion_depth
     * This thing has a tendency to run-away on me. This tracks
     * how bad I messed up by seeing how far the expanded types
     * go
     *
     * @return UnionType
     * Expands all class types to all inherited classes returning
     * a superset of this type.
     */
    public function asExpandedTypes(
        CodeBase $code_base,
        int $recursion_depth = 0
    ) : UnionType {
        return $this;
    }

    /**
     * As per the Serializable interface
     *
     * @return string
     * A serialized representation of this type
     *
     * @see \Serializable
     */
    public function serialize() : string
    {
        return '';
    }

    /**
     * @return string
     * A human-readable string representation of this union
     * type
     */
    public function __toString() : string
    {
        return '';
    }

    /**
     * @return UnionType - A normalized version of this union type (May or may not be the same object, if no modifications were made)
     *
     * The following normalization rules apply
     *
     * 1. If one of the types is null or nullable, convert all types to nullable and remove "null" from the union type
     * 2. If both "true" and "false" (possibly nullable) coexist, or either coexists with "bool" (possibly nullable),
     *    then remove "true" and "false"
     */
    public function asNormalizedTypes() : UnionType
    {
        return $this;
    }

    public function hasTopLevelArrayShapeTypeInstances() : bool
    {
        return false;
    }

    /** @override */
    public function hasArrayShapeTypeInstances() : bool
    {
        return false;
    }

    /** @override */
    public function withFlattenedArrayShapeTypeInstances() : UnionType
    {
        return $this;
    }

    public function hasPossiblyObjectTypes() : bool
    {
        return false;
    }

    public function isExclusivelyBoolTypes() : bool
    {
        return false;
    }

    public function generateUniqueId() : string
    {
        return '';
    }

    public function hasTopLevelNonArrayShapeTypeInstances() : bool
    {
        return false;
    }

    public function shouldBeReplacedBySpecificTypes() : bool
    {
        return true;
    }

    /**
     * @param int|string $field_key
     */
    public function withoutArrayShapeField($field_key) : UnionType
    {
        return $this;
    }
}
