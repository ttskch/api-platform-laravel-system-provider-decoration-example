#!/bin/sh -eu

# Insert filtering process with SkipAutoconfigure attribute into ApiPlatformDeferredProvider

TARGET_FILE="vendor/api-platform/laravel/ApiPlatformDeferredProvider.php"

# Check if the operation has already been inserted
if grep -q "SkipAutoconfigure::class" "$TARGET_FILE"; then
    echo "The filtering process has already been inserted."
    exit 0
fi

# Create a temporary file
TEMP_FILE=$(mktemp)

# Insert new code before line 105
awk '
NR == 105 {
    print "        foreach ($classes as $className => $refl) {"
    print "            foreach ($refl->getAttributes() as $attribute) {"
    print "                if ($attribute->getName() === \\App\\Attribute\\SkipAutoconfigure::class) {"
    print "                    unset($classes[$className]);"
    print "                    break;"
    print "                }"
    print "            }"
    print "        }"
    print ""
    print $0
    next
}
{ print }
' "$TARGET_FILE" > "$TEMP_FILE"

# Overwrite the original file
mv "$TEMP_FILE" "$TARGET_FILE"

echo "A filtering process has been inserted into ApiPlatformDeferredProvider.php."
