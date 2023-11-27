#include <iostream>

void swap(int &a, int &b) {
    int temp = a;
    a = b;
    b = temp;
}


void printArray(int arr[], int size) {
    for (int i=0; i < size; i++) {
        std::cout << arr[i] << " ";
    }
    std::cout << std::endl;
}

void bubbleSort(int arr[], int n) {
    for (int i = 0; i < n-1; i++) {
        for (int j = 0; j < n-i-1; j++) {
            // Troca os elementos se estiverem na ordem errada
            if (arr[j] > arr[j+1]) {
                swap(arr[j], arr[j+1]);
                printArray(arr, n);
            }
        }
    }
}



