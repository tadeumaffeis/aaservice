#include <iostream>

using namespace std;

extern void bubbleSort(int arr[], int n);
extern void selectionSort(int arr[], int n);
void insertionSort(int arr[], int n);
extern void printArray(int arr[], int size);

int main() {
    int arr[] = {10,9,8,7,6,5,4,3,2,1};
    int n = sizeof(arr)/sizeof(arr[0]);

    std::cout << "Array original: ";
    printArray(arr, n);

    insertionSort(arr, n);

    std::cout << "Array ordenado: ";
    printArray(arr, n);

    return 0;
}
