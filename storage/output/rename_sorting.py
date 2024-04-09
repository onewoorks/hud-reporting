import os
import sys

def rename_folders(root_dir):
    for dirpath, dirnames, filenames in os.walk(root_dir):
        for i, dirname in enumerate(dirnames):
            original_path = os.path.join(dirpath, dirname)
            new_dirname = pad_folder_names(dirname)
            new_path = os.path.join(dirpath, new_dirname)
            os.rename(original_path, new_path)
            dirnames[i] = new_dirname  # Update dirnames list with renamed folder name
            print(f"Renamed: {original_path} -> {new_path}")

def pad_folder_names(folder_name):
    parts = folder_name.split(' ')
    padded_parts = [part if not part.isdigit() else part.zfill(3) for part in parts]
    return ' '.join(padded_parts)

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python rename_folders.py <directory_path>")
        sys.exit(1)
    
    directory_path = sys.argv[1]
    rename_folders(directory_path)
